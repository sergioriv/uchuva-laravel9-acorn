<?php

namespace App\Http\Controllers\waiter;

use App\Http\Controllers\Controller;
use App\Http\Controllers\support\UserController;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Dish;
use App\Models\Order;
use App\Models\OrderDish;
use App\Models\Table;
use App\Models\User;
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
        switch (UserController::role_auth()):
            case 'Waiter':
                return view('waiter.orders.index');

            case 'Branch':
                return view('branch.orders.index');

            default:
                return redirect()->route('dashboard')->with(
                    ['notify' => 'fail', 'title' => __('Unauthorized!')],
                );

        endswitch;
    }

    public function data()
    {
        $parents = $this->parents()[0];

        switch (UserController::role_auth()):
            case 'Waiter':
                return [
                    'data' => Order::with('table')
                        ->select('id', 'table_id', 'code', 'total', 'created_at')
                        ->where('waiter_id', '=', $parents->id)
                        ->whereNull('finished')
                        ->orderBy('id', 'DESC')
                        ->get()
                ];

            case 'Branch':
                return [
                    'data' => Order::with('table')
                        ->with('waiter')->whereHas('waiter', function ($waiter) use ($parents) {
                            $waiter->where('branch_id', $parents->id);
                        })
                        ->whereNull('finished')
                        ->orderBy('id', 'DESC')
                        ->get()
                ];

            default:
                return null;

        endswitch;
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
                if ($dish->available != NULL) {
                    $dish_quality = 'dish-quality-' . $dish->id;

                    if ($request->$dish_quality > 0) {
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


                        /* Updating the quality and available of the dish. */
                        $new_quality_dish = ($dish->quality - $request->$dish_quality);

                        if ($new_quality_dish > 0) :
                            $dish->update([
                                'quality' => $new_quality_dish
                            ]);
                        else :
                            $dish->update([
                                'quality' => $new_quality_dish,
                                'available' => NULL
                            ]);
                        endif;
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
        // return $order;
        // return view('branch.orders.show')->with('order', $order);
        return redirect()->route('waiter.orders.edit', $order);
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

        if ($request->finished) {
            $order->update([
                'finished' => TRUE
            ]);
            $titleNotify = __('Order delivered') . '!';
        } else {

            $totalOrden = 0;

            $categories = $this->dishes_categories();
            foreach ($categories as $category) :
                foreach ($category->dishes as $dish) :

                    $dish_quality = 'dish-quality-' . $dish->id;

                    if ($request->$dish_quality > 0) {

                        $dish_price = 'dish-price-' . $dish->id;
                        $dish_note = 'dish-note-' . $dish->id;

                        $dishOrder = OrderDish::where('order_id', $order->id)->where('dish_id', $dish->id)->first();

                        if ($dishOrder) {

                            /* Updating the quality of the dish. */
                            $new_quality_dish = ($dish->quality - ($request->$dish_quality - $dishOrder->quality));


                            /* Updating the quality and note of the dish order. */
                            $dishOrder->update([
                                'quality' => $request->$dish_quality,
                                'note' => $request->$dish_note
                            ]);
                        } else {
                            OrderDish::create([
                                'order_id' => $order->id,
                                'dish_id' => $dish->id,
                                'price' => $request->$dish_price,
                                'quality' => $request->$dish_quality,
                                'note' => $request->$dish_note
                            ]);


                            /* Updating the quality of the dish. */
                            $new_quality_dish = ($dish->quality - $request->$dish_quality);
                        }

                        /* Updating the quality and available of the dish. */
                        if ($new_quality_dish > 0) :
                            $dish->update([
                                'quality' => $new_quality_dish,
                                'available' => TRUE
                            ]);
                        else :
                            $dish->update([
                                'quality' => $new_quality_dish,
                                'available' => NULL
                            ]);
                        endif;


                        $totalOrden += ($request->$dish_quality * $request->$dish_price);
                    }

                endforeach;
            endforeach;

            $order->update([
                'total' => $totalOrden
            ]);

            $titleNotify = __('Order Updated!');
        }


        return redirect()->route('waiter.orders.index')->with(
            ['notify' => 'success', 'title' => $titleNotify],
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

            case 'Branch':
                return Branch::findOrFail(Auth::user()->id)->select('id', 'restaurant_id')->get();

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
