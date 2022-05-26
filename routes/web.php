<?php

use App\Http\Controllers\Auth\ConfirmEmailController;
use App\Http\Controllers\branch\WaiterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\restaurant\BranchController;
use App\Http\Controllers\support\RestaurantController;
use App\Http\Controllers\support\RoleController;
use App\Http\Controllers\support\SubscriptionController;
use App\Http\Controllers\support\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard'); })->name('dashboard');

    Route::get('insert_roles', [UserController::class, 'insert_roles']);
    Route::get('destroy_users', [UserController::class, 'destroy_users']);


    /* Route Users */
    Route::put('change-password', [ConfirmEmailController::class, 'change_password'])->name('support.users.password');
    Route::resource('users', UserController::class)->except('destroy','create','store')->names('support.users');
    Route::get('users.json', [UserController::class, 'data']);

    /* Route Profile */
    Route::get('profile', [ProfileController::class, 'show'])->name('user.profile');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('user.profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('user.profile.update');

    /* Route Roles */
    Route::resource('roles', RoleController::class)->except('destroy','show')->names('support.roles');
    Route::get('roles.json', [RoleController::class, 'data']);

    /* Route Restaurants */
    Route::resource('restaurants', RestaurantController::class)->except('destroy')->names('support.restaurants');
    Route::get('restaurants.json', [RestaurantController::class, 'data']);

    /* Route Restaurants Subscriptions */
    Route::resource('restaurants/{restaurant}/subscriptions', SubscriptionController::class)->only('create','store')->names('support.subscriptions');
    Route::get('restaurants/{restaurant}/subscriptions.json', [SubscriptionController::class, 'data']);

    /* Route Branches */
    Route::resource('branches', BranchController::class)->names('restaurant.branches');
    Route::get('branches.json', [BranchController::class, 'data']);

    /* Route Waiters */
    Route::resource('waiters', WaiterController::class)->names('branch.waiters');
    Route::get('waiters.json', [WaiterController::class, 'data']);

    /* Route Categories */
    Route::resource('categories', WaiterController::class)->names('restaurant.categories');
    Route::get('categories.json', [WaiterController::class, 'data']);
});


require __DIR__.'/auth.php';
