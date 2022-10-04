<?php

namespace App\Http\Controllers\restaurant;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;

class MyRestaurant extends Controller
{
    function __construct()
    {

    }

    private static function my()
    {
        return Restaurant::where('user_id', Auth::user()->id)->first() ?? NULL;
    }

    public static function name()
    {
        return static::my()->name ?? null;
    }

    public static function avatar()
    {
        return static::my()->user->avatar ?? null;
    }
    public static function nit()
    {
        return static::my()->nit ?? null;
    }
    public static function telephone()
    {
        return static::my()->telephone ?? null;
    }
}
