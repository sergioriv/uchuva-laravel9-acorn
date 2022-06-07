<?php

namespace App\Http\Controllers\waiter;

use App\Http\Controllers\Controller;
use App\Http\Controllers\support\UserController;
use App\Models\Category;
use App\Models\Dish;
use App\Models\Order;
use App\Models\OrderDish;
use App\Models\Table;
use App\Models\Waiter;
use Illuminate\Support\Str;
use App\Rules\TablesExistRule;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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
        return ['data' => Order::with('table')
                ->select('id','table_id','code','total','created_at')
                ->where('waiter_id', '=', $this->parents()[0]->id)
                ->whereNull('finished')
                ->orderBy('id', 'DESC')
                ->get()
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parents = $this->parents()[0];
        $tables = Table::where('branch_id', '=', $parents->branch_id)->get();
        $categories = $this->dishes_categories();
        return view('waiter.orders.create')->with(['tables' => $tables, 'categories' => $categories]);
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
            'table' => ['required', 'numeric', 'min:0', new TablesExistRule()]
        ]);

        $parents = $this->parents()[0];

        $order = Order::create([
            'restaurant_id' => $parents->restaurant_id,
            'table_id'      => $request->table,
            'waiter_id'     => $parents->id,
            'code'          => Str::upper(Str::random(8)),
            'total'         => 0
        ]);

        $totalOrden = 0;

        $categories = $this->dishes_categories();
        foreach ($categories as $category) {
            foreach ($category->dishes as $dish) {
                if ($dish->available != NULL)
                {
                    $dish_quality = 'dish-quality-' . $dish->id;

                    if ( $request->$dish_quality > 0 )
                    {
                        $dish_price = 'dish-price-' . $dish->id;
                        $dish_note = 'dish-note-' . $dish->id;

                        $totalOrden += ($request->$dish_quality * $request->$dish_price);

                        OrderDish::create([
                            'order_id' => $order->id,
                            'dish_id' => $dish->id,
                            'price' => $request->$dish_price,
                            'quality' => $request->$dish_quality,
                            'note' => $request->$dish_note
                        ]);

                    }
                }
            }
        }

        $order->update([
            'total' => $totalOrden
        ]);

        return redirect()->route('waiter.orders.index')->with(
            ['notify' => 'success', 'title' => __('Order created!')],
        );
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
        $order->table;
        $order->dishes;

        $categories = $this->dishes_categories();

        return view('waiter.orders.edit')->with(['order' => $order, 'categories' => $categories]);
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

        $totalOrden = 0;

        $categories = $this->dishes_categories();
        foreach ($categories as $category) :
            foreach ($category->dishes as $dish) :
                // if ($dish->available != NULL)
                // {
                    $dish_quality = 'dish-quality-' . $dish->id;

                    if ( $request->$dish_quality > 0 )
                    {

                        $dish_price = 'dish-price-' . $dish->id;
                        $dish_note = 'dish-note-' . $dish->id;

                        $dishOrder = OrderDish::where('order_id', $order->id)->where('dish_id', $dish->id)->first();

                        if ($dishOrder)
                        {
                            $dishOrder->update([
                                'quality' => $request->$dish_quality,
                                'note' => $request->$dish_note
                            ]);
                        } else
                        {
                            OrderDish::create([
                                'order_id' => $order->id,
                                'dish_id' => $dish->id,
                                'price' => $request->$dish_price,
                                'quality' => $request->$dish_quality,
                                'note' => $request->$dish_note
                            ]);
                        }

                        $totalOrden += ($request->$dish_quality * $request->$dish_price);

                    }
                // }
            endforeach;
        endforeach;

        $order->update([
            'total' => $totalOrden
        ]);

        return redirect()->route('waiter.orders.index')->with(
            ['notify' => 'success', 'title' => __('Order Updated!')],
        );
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

    private function dishes_categories()
    {
        $parents = $this->parents()[0];
        return Category::with('dishes')
            ->whereHas('dishes', function (Builder $query) {
                $query->whereNotNull('available');
            })
            ->where('restaurant_id', '=', $parents->restaurant_id)->get();
    }
}
