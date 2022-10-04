<?php

namespace App\Http\Controllers\restaurant;

use App\Http\Controllers\Controller;
use App\Http\Controllers\support\UserController;
use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:categories');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('restaurant.categories.index', [
            'categories' => Category::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('restaurant.categories.create');
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
            'name' => ['required', 'min:1', 'max:20']
        ]);

        Category::create([
            'restaurant_id' => $this->restaurant(),
            'name' => $request->name
        ]);

        return redirect()->route('restaurant.categories.index')->with(
            ['notify' => 'success', 'title' => __('Category created!')],
        );
    }

    public function show(Category $category)
    {
        return redirect()->route('restaurant.categories.edit', $category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('restaurant.categories.edit')->with('category', $category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => ['required', 'max:20']
        ]);

        $category->update([
            'name' => $request->name
        ]);

        return redirect()->route('restaurant.categories.index')->with(
            ['notify' => 'success', 'title' => __('Category created!')],
        );
    }

    public function destroy(Category $category)
    {
        if ( $category->dishes->count() > 0 ) {
            return redirect()->back()->with(
                ['notify' => 'fail', 'title' => __('Not allowed')],
            );
        }

        $category->delete();

        return redirect()->route('restaurant.categories.index')->with(
            ['notify' => 'success', 'title' => __('Category deleted!')],
        );
    }

    private function restaurant()
    {
        switch (UserController::role_auth()) {
            case 'RESTAURANT':
                return Restaurant::where('user_id', Auth::user()->id)->first()->id;

            default:
                return null;
        }
    }
}
