<?php

namespace App\Http\Controllers\branch;

use App\Http\Controllers\Controller;
use App\Http\Controllers\support\UserController;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Dish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\This;

class DishController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:dishes');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('branch.dishes.index');
    }

    public function data()
    {
        return ['data' => Dish::with('category')->where('branch_id', '=', $this->parents()[0]->id)->orderBy('available', 'desc')->get()];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('restaurant_id', '=', $this->parents()[0]->restaurant_id)->get();
        return view('branch.dishes.create')->with('categories', $categories);
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
            'name'      => ['required', 'string', 'max:50'],
            'description' => ['string', 'max:255'],
            'price' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/', 'min:0'],
            'quality' => ['required', 'numeric', 'min:0'],
            'available' => ['boolean']
        ]);

        $parents = $this->parents()[0];

        Dish::create([
            'restaurant_id' => $parents->restaurant_id,
            'branch_id' => $parents->id,
            'category_id' => $request->category,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quality' => $request->quality,
            'available' => $request->available
        ]);

        return redirect()->route('branch.dishes.index')->with(
            ['notify' => 'success', 'title' => __('Dish created!')],
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function show(Dish $dish)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function edit(Dish $dish)
    {
        $categories = Category::where('restaurant_id', '=', $this->parents()[0]->restaurant_id)->get();
        return view('branch.dishes.edit')->with(['dish' => $dish, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dish $dish)
    {
        $request->validate([
            'name'      => ['required', 'string', 'max:50'],
            'description' => ['string', 'max:255'],
            'price' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/', 'min:0'],
            'quality' => ['required', 'numeric', 'min:0'],
            'available' => ['boolean']
        ]);

        $dish->update([
            'category_id' => $request->category,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quality' => $request->quality,
            'available' => $request->available
        ]);

        return redirect()->route('branch.dishes.index')->with(
            ['notify' => 'success', 'title' => __('Dish updated!')],
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dish $dish)
    {
        //
    }


    private function parents()
    {
        switch (UserController::role_auth()) {
            case 'Branch':
                return Branch::findOrFail(Auth::user()->id)->select('id', 'restaurant_id')->get();

            default:
                return null;
        }
    }
}
