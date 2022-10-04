<?php

namespace App\Http\Controllers;

use App\Http\Controllers\restaurant\WaiterController;
use App\Http\Controllers\support\RestaurantController;
use App\Http\Controllers\support\UserController;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\Waiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        switch (UserController::role_auth()) {
            case 'RESTAURANT':
                $restaurant = Restaurant::where('user_id',Auth::user()->id)->firstOrFail();
                return view('profile.restaurant', ['restaurant' => $restaurant]);
                break;

            case 'WAITER':
                $waiter = Waiter::where('user_id',Auth::user()->id)->firstOrFail();
                return view('profile.waiter-edit', ['waiter' => $waiter]);
                break;

            default:
                return $this->not_found();
                break;
        }
    }

    public function edit()
    {
        switch (UserController::role_auth()) {
            case 'RESTAURANT':
                $restaurant = Restaurant::where('user_id',Auth::user()->id)->firstOrFail();
                return view('profile.restaurant-edit', ['restaurant' => $restaurant]);
                break;

            case 'WAITER':
                $waiter = Waiter::where('user_id',Auth::user()->id)->firstOrFail();
                return view('profile.waiter-edit', ['waiter' => $waiter]);
                break;

            default:
                return $this->not_found();
                break;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        switch (UserController::role_auth()) {
            case 'RESTAURANT':
                $restaurant = Restaurant::where('user_id',Auth::user()->id)->firstOrFail();
                RestaurantController::profile_update($request, $restaurant);
                break;

            case 'WAITER':
                $waiter = Waiter::where('user_id',Auth::user()->id)->firstOrFail();
                WaiterController::profile_update($request, $waiter);
                break;

            default:
                return $this->not_found();
                break;
        }

        return redirect()->route('user.profile')->with(
            ['notify' => 'success', 'title' => __('Updated!')],
        );
    }

    private function not_found()
    {
        return redirect()->route('dashboard')->with(
            ['notify' => 'fail', 'title' => __('Unauthorized!')],
        );
    }
}
