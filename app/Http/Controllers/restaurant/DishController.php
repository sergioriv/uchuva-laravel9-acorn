<?php

namespace App\Http\Controllers\restaurant;

use App\Http\Controllers\Controller;
use App\Http\Controllers\support\UserController;
use App\Models\Category;
use App\Models\Dish;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

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
        return view('restaurant.dishes.index', [
            'dishes' => Dish::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('restaurant_id', '=', $this->restaurant())->get();
        return view('restaurant.dishes.create')->with('categories', $categories);
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
            'image' => ['image', 'mimes:jpg,jpeg,png,webp','max:2048'],
            'name'      => ['required', 'string', 'max:50'],
            'description' => ['string', 'max:255'],
            'price' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/', 'min:0'],
            'quality' => ['required', 'numeric', 'min:0', 'max:100'],
            'available' => ['boolean']
        ]);


        $dish = Dish::create([
            'restaurant_id' => $this->restaurant(),
            'category_id' => $request->category,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quality' => $request->quality,
            'available' => $request->available
        ]);

        self::uploadImage($dish, $request);


        return redirect()->route('restaurant.dishes.index')->with(
            ['notify' => 'success', 'title' => __('Dish created!')],
        );
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function edit(Dish $dish)
    {
        $categories = Category::where('restaurant_id', '=', $this->restaurant())->get();
        return view('restaurant.dishes.edit', [
            'dish' => $dish,
            'categories' => $categories
        ]);
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

        self::uploadImage($dish, $request);

        return redirect()->route('restaurant.dishes.index')->with(
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
        if ( $dish->orders->count() > 0 ) {
            return redirect()->back()->with(
                ['notify' => 'fail', 'title' => __('Not allowed')],
            );
        }

        $dish->delete();

        return redirect()->route('restaurant.dishes.index')->with(
            ['notify' => 'success', 'title' => __('Dish deleted!')],
        );
    }


    private function uploadImage($dish, $request)
    {
        $file = 'image';
        if ($request->hasFile($file)) {
            if ($request->file($file)->isValid()) {

                if ($dish->image !== NULL) {
                    File::delete(public_path($dish->image));
                }

                $path = $request->file($file)->store('restaurant/'. self::restaurant() .'/dishes', 'public');
                $pathSave = config('filesystems.disks.public.url') .'/' . $path;

                $dish->update(['image' => $pathSave]);
            }
        }

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
