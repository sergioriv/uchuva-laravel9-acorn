<?php

namespace App\Http\Controllers\support;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Subscription;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{

    public function data(Restaurant $restaurant)
    {
        return ['data' => Subscription::where('restaurant_id', '=', $restaurant->id)->get()];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Restaurant $restaurant)
    {
        $restaurant->user;
        return view('support.subscriptions.create')->with('restaurant', $restaurant);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Restaurant $restaurant)
    {
        $payment_date = $request->date .' '. $request->time;
        $unsubscribe = Carbon::parse($payment_date)->addMonths($request->quantity);

        Subscription::create([
            'restaurant_id' => $restaurant->id,
            'quantity' => $request->quantity,
            'payment_date' => $payment_date,
            'unsubscribe' => $unsubscribe
        ]);

        RestaurantController::_unsubscribe($restaurant, $unsubscribe);

        return redirect()->route('support.restaurants.show', $restaurant)->with(
            ['notify' => 'success', 'title' => __('Saved payment!')],
        );
    }


}
