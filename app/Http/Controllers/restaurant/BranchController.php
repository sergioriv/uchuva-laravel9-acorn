<?php

namespace App\Http\Controllers\restaurant;

use App\Http\Controllers\Controller;
use App\Http\Controllers\support\UserController;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Validation\Rule;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('restaurant.branches.index');
    }

    public function data()
    {
        return ['data' => Branch::with('user')->where('restaurant_id', '=', $this->restaurant())->get()];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $deps = json_decode(file_get_contents('json/colombia.min.json'), true);
        return view('restaurant.branches.create')->with('deps', $deps);
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
            'avatar'     => ['image', 'max:2024'],
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255', 'unique:App\Models\User,email'],
            'telephone' => ['required', 'string', 'max:20'],
            'city'      => ['required', 'string', 'max:100'],
            'address'   => ['string', 'max:255'],
        ]);

        $avatar = UserController::upload_avatar($request);

        $user = UserController::_create($request->name, $request->email, 3, $avatar);

        Branch::create([
            'id' => $user->id,
            'restaurant_id' => $this->restaurant(),
            'code' => Str::upper(Str::random(5)),
            'city' => $request->city,
            'address' => $request->address,
            'telephone' => $request->telephone
        ]);

        return redirect()->route('restaurant.branches.index')->with(
            ['notify' => 'success', 'title' => __('Branch created!')],
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch)
    {
        $branch->user;
        return view('restaurant.branches.show')->with('branch', $branch);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function edit(Branch $branch)
    {
        $branch->user;
        $deps = json_decode(file_get_contents('json/colombia.min.json'), true);

        return view('restaurant.branches.edit')->with(['branch' => $branch, 'deps' => $deps]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'avatar'     => ['image', 'max:2024'],
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255', Rule::unique('users')->ignore($branch->id)],
            'telephone' => ['required', 'string', 'max:20'],
            'city'      => ['required', 'string', 'max:100'],
            'address'   => ['string', 'max:255'],
        ]);

        $avatar = UserController::upload_avatar($request);

        if ( $request->hasFile('avatar') )
            File::delete(public_path($branch->user->avatar));

        if( $request->name != $branch->user->name
            || $request->email != $branch->user->email
            || $avatar != $branch->user->avatar )
            UserController::_update($branch->id, $request->name, $request->email, $avatar);

       $branch->update([
            'city' => $request->city,
            'address' => $request->address,
            'telephone' => $request->telephone
        ]);

        return redirect()->route('restaurant.branches.index')->with(
            ['notify' => 'success', 'title' => __('Branch created!')],
        );
    }

    private function restaurant()
    {
        switch (UserController::role_auth()) {
            case 'Restaurant':
                return Auth::user()->id;

            default:
                return null;
        }
    }
}
