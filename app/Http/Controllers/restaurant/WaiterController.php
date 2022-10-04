<?php

namespace App\Http\Controllers\restaurant;

use App\Http\Controllers\Controller;
use App\Http\Controllers\support\UserController;
use App\Models\Restaurant;
use App\Models\Waiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
        return view('restaurant.waiters.index', [
            'waiters' => Waiter::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('restaurant.waiters.create');
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
            'email'     => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'telephone' => ['required', 'string', 'max:20']
        ]);


        $user = UserController::_create($request->name, $request->email, 3);

        if (!$user) {
            return redirect()->back()->with(
                ['notify' => 'fail', 'title' => __('Invalid email (:email)', ['email' => $request->email])],
            );
        }



        if ($request->has('avatar'))
            UserController::upload_avatar($request, $user);

        Waiter::create([
            'user_id' => $user->id,
            'restaurant_id' => $this->restaurant(),
            'name' => $request->name,
            'telephone' => $request->telephone
        ]);

        return redirect()->route('restaurant.waiters.index')->with(
            ['notify' => 'success', 'title' => __('Waiter created!')],
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\waiter  $waiter
     * @return \Illuminate\Http\Response
     */
    public function edit(Waiter $waiter)
    {
        return view('restaurant.waiters.edit', ['waiter' => $waiter]);
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


        UserController::_update($waiter->user->id, $request->name, null);

        UserController::upload_avatar($request, $waiter->user);

        $waiter->update([
            'name' => $request->name,
            'telephone' => $request->telephone
        ]);

        return redirect()->route('restaurant.waiters.index')->with(
            ['notify' => 'success', 'title' => __('Waiter updated!')],
        );
    }


    private function restaurant()
    {
        switch (UserController::role_auth()) {
            case 'RESTAURANT':
                return Restaurant::where('user_id', Auth::user()->id)->first()->id;

            default:
                return null;
        }
    }

    public static function profile_update(Request $request, Waiter $waiter)
    {
        $request->validate([
            'avatar'     => ['image', 'mimes:jpg,jpeg,png,webp','max:2048'],
            'name'      => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'string', 'max:20']
        ]);

        if ($request->has('avatar'))
            UserController::upload_avatar($request, $waiter->user);


        if( $request->name != $waiter->name )
            UserController::_update($waiter->user->id, $request->name, null);

        $waiter->update([
            'name' => $request->name,
            'telephone' => $request->telephone
        ]);
    }
}
