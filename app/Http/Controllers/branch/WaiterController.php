<?php

namespace App\Http\Controllers\branch;

use App\Http\Controllers\Controller;
use App\Http\Controllers\support\UserController;
use App\Models\Branch;
use App\Models\Waiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class WaiterController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:waiters');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('branch.waiters.index');
    }

    public function data()
    {
        return ['data' => Waiter::with('user')->where('branch_id', '=', $this->parents()[0]->id)->get()];
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('branch.waiters.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'avatar'     => ['image', 'max:2048'],
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255', 'unique:App\Models\User,email'],
            'telephone' => ['required', 'string', 'max:20']
        ]);

        $avatar = UserController::upload_avatar($request);

        $user = UserController::_create($request->name, $request->email, 4, $avatar);

        $parents = $this->parents()[0];

        Waiter::create([
            'id' => $user->id,
            'restaurant_id' => $parents->restaurant_id,
            'branch_id' => $parents->id,
            'telephone' => $request->telephone
        ]);

        return redirect()->route('branch.waiters.index')->with(
            ['notify' => 'success', 'title' => __('Waiter created!')],
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\waiter  $waiter
     * @return \Illuminate\Http\Response
     */
    public function show(Waiter $waiter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\waiter  $waiter
     * @return \Illuminate\Http\Response
     */
    public function edit(Waiter $waiter)
    {
        $waiter->user;
        return view('branch.waiters.edit')->with('waiter', $waiter);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\waiter  $waiter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Waiter $waiter)
    {
        $request->validate([
            'avatar'     => ['image', 'max:2048'],
            'name'      => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'string', 'max:20']
        ]);

        $avatar = UserController::upload_avatar($request);

        $user = UserController::_update($waiter->id, $request->name, null, $avatar);

        $waiter->update([
            'telephone' => $request->telephone
        ]);

        return redirect()->route('branch.waiters.index')->with(
            ['notify' => 'success', 'title' => __('Waiter updated!')],
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\waiter  $waiter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Waiter $waiter)
    {
        //
    }


    private function parents()
    {
        switch (UserController::role_auth()) {
            case 'Branch':
                return Branch::findOrFail(Auth::user()->id)->select('id', 'restaurant_id')->get();

            default:
                return null;
        }
    }

    public static function profile_update(Request $request, Waiter $waiter)
    {
        $request->validate([
            'avatar'     => ['image', 'max:2048'],
            'name'      => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'string', 'max:20']
        ]);

        $avatar = UserController::upload_avatar($request);

        if ( $request->hasFile('avatar') )
            File::delete(public_path($waiter->user->avatar));

        if( $request->name != $waiter->user->name
            || $avatar != $waiter->user->avatar )
            UserController::_update($waiter->id, $request->name, null, $avatar);

        $waiter->update([
            'telephone' => $request->telephone
        ]);
    }
}
