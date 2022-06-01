<?php

namespace App\Http\Controllers\waiter;

use App\Http\Controllers\Controller;
use App\Http\Controllers\support\UserController;
use App\Models\Order;
use App\Models\Table;
use App\Models\Waiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:orders.index')->only('index');
        $this->middleware('can:orders.create')->only('create');
        $this->middleware('can:orders.show')->only('show');
        $this->middleware('can:orders.edit')->only('edit');
        $this->middleware('can:orders.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('waiter.orders.index');
    }

    public function data()
    {
        return ['data' => Order::with('table')->where('waiter_id', '=', $this->parents()[0]->id)->get()];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $tables = Table::where('restaurant_id', '=', $this->parents()[0]->restaurant_id)->get();
        // return view('branch.dishes.create')->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }


    private function parents()
    {
        switch (UserController::role_auth()) {
            case 'Waiter':
                return Waiter::findOrFail(Auth::user()->id)->select('id', 'restaurant_id', 'branch_id')->get();

            default:
                return null;
        }
    }
}
