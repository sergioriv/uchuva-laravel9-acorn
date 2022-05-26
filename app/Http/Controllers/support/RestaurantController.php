<?php

namespace App\Http\Controllers\support;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class RestaurantController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:support.restaurants');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('support.restaurants.index');
    }

    public function data()
    {
        return ['data' => Restaurant::with('user')->orderBy('id','DESC')->get()];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('support.restaurants.create');
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:App\Models\User,email'],
            'nit' => ['required', 'string', 'max:20'],
            'telephone' => ['required', 'string', 'max:20'],
            'subscription' => ['required', 'numeric', 'min:1']
        ]);

        $user = UserController::_create($request->name, $request->email, 2, null);

        Restaurant::create([
            'id' => $user->id,
            'nit' => $request->nit,
            'telephone' => $request->telephone,
            'unsubscribe' => now()->addMonth($request->subscription),
        ]);

        return redirect()->route('support.restaurants.index')->with(
            ['notify' => 'success', 'title' => __('Restaurant created!')],
        );
    }

    public static function _unsubscribe(Restaurant $restaurant, $unsubscribe)
    {
        $restaurant->update([
            'unsubscribe' => $unsubscribe
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Restaurant $restaurant)
    {
        $restaurant->user;
        return view('support.restaurants.show')->with('restaurant', $restaurant);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Restaurant $restaurant)
    {
        return view('support.restaurants.edit')->with('restaurant', $restaurant);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($restaurant->id)],
            'nit' => ['required', 'string', 'max:20'],
            'telephone' => ['required', 'string', 'max:20']
        ]);

        if( $request->name != $restaurant->user->name || $request->email != $restaurant->user->email )
            UserController::_update($restaurant->id, $request->name, $request->email, null);

        $restaurant->update([
            'nit' => $request->nit,
            'telephone' => $request->telephone
        ]);

        return redirect()->route('support.restaurants.index')->with(
            ['notify' => 'success', 'title' => __('Restaurant updated!')],
        );
    }



    public static function profile_update(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nit' => ['required', 'string', 'max:20'],
            'telephone' => ['required', 'string', 'max:20']
        ]);

        $avatar = UserController::upload_avatar($request);

        if ( $request->hasFile('avatar') )
            File::delete(public_path($restaurant->user->avatar));

        if( $request->name != $restaurant->user->name
            || $avatar != $restaurant->user->avatar  )
            UserController::_update($restaurant->id, $request->name, null, $avatar);

        $restaurant->update([
            'nit' => $request->nit,
            'telephone' => $request->telephone
        ]);
    }

}
