<?php

namespace App\Http\Controllers\support;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Subscription;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class RestaurantController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:support.access');
        $this->middleware('can:support.restaurants');
    }

    /**
     * > This function returns a view of all restaurants
     *
     * @return View 'support.restaurants.index' and the variable 'restaurants' is being passed to
     * the view.
     */
    public function index()
    {
        return view('support.restaurants.index', ['restaurants' => Restaurant::all()]);
    }

    /**
     * It returns a view called `support.restaurants.create`
     *
     * @return View called support.restaurants.create
     */
    public function create()
    {
        return view('support.restaurants.create');
    }

    /**
     * It creates a new restaurant
     *
     * @param Request request The request object.
     *
     * @return Redirect to the route support.restaurants.index with a success notification.
     */
    public function store(Request $request)
    {
        $request->validate([
            // 'name' => ['required', 'string', 'min:1', 'max:255', Rule::unique('restaurants', 'name')],
            'email' => ['required', 'email', 'min:1', 'max:255', Rule::unique('users', 'email')],
            'nit' => ['required', 'string', 'min:1', 'max:20'],
            'telephone' => ['required', 'string', 'min:1','max:20'],
            'subscription' => ['required', 'numeric', 'min:1']
        ]);


        $slug = Str::slug($request->name);
        $checkSlug = Restaurant::where('slug', $slug)->first();
        if (NULL !== $checkSlug)
        {
            return redirect()->back()->with(
                ['notify' => 'fail', 'title' => __(':name has already been taken.', ['name' => $request->name])],
            );
        }

        $user = UserController::_create($request->name, $request->email, 2, null);

        if (!$user) {
            return redirect()->back()->with(
                ['notify' => 'fail', 'title' => __('Invalid email (:email)', ['email' => $request->email])],
            );
        }


        Restaurant::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'slug' => $slug,
            'nit' => $request->nit,
            'telephone' => $request->telephone,
            'unsubscribe' => now()->addMonth($request->subscription),
        ]);

        return redirect()->route('support.restaurants.index')->with(
            ['notify' => 'success', 'title' => __('Restaurant created!')],
        );
    }

    /**
     * > Update the unsubscribe column of the restaurant table with the value of the
     * variable
     *
     * @param Restaurant restaurant The restaurant object that you want to update.
     * @param unsubscribe true or false
     */
    public static function _unsubscribe(Restaurant $restaurant, $unsubscribe)
    {
        $restaurant->update([
            'unsubscribe' => $unsubscribe
        ]);
    }

    /**
     * It returns a view called `support.restaurants.show` and passes it two variables: `restaurant`
     * and `subscriptions`
     *
     * @param Restaurant restaurant This is the restaurant object that we're passing to the view.
     *
     * @return A view with the restaurant and subscriptions
     */
    public function show(Restaurant $restaurant)
    {

        return view('support.restaurants.show', [
            'restaurant' => $restaurant,
            'subscriptions' => Subscription::where('restaurant_id', $restaurant->id)
                                ->orderByDesc('created_at')->get()
        ]);
    }

    /**
     * The edit function returns a view with the restaurant object passed to it
     *
     * @param Restaurant restaurant The model instance passed to the view.
     *
     * @return The view support.restaurants.edit with the restaurant object
     */
    public function edit(Restaurant $restaurant)
    {
        return view('support.restaurants.edit')->with('restaurant', $restaurant);
    }

    /**
     * It updates the restaurant's information, and if the name or email of the restaurant's user is
     * changed, it updates the user's information
     *
     * @param Request request The request object.
     * @param Restaurant restaurant The model we're binding to.
     *
     * @return A redirect to the index page with a success message.
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($restaurant->id)],
            'nit' => ['required', 'string', 'max:20'],
            'telephone' => ['required', 'string', 'max:20']
        ]);

        if( $request->name != $restaurant->user->name )
            UserController::_update($restaurant->id, $request->name, null);

        $restaurant->update([
            'nit' => $request->nit,
            'telephone' => $request->telephone
        ]);

        return redirect()->route('support.restaurants.index')->with(
            ['notify' => 'success', 'title' => __('Restaurant updated!')],
        );
    }



    /**
     * It updates the user's avatar and name if they have changed, and then updates the restaurant's
     * nit and telephone
     *
     * @param Request request The request object.
     * @param Restaurant restaurant The model instance passed to the route
     */
    public static function profile_update(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nit' => ['required', 'string', 'max:20'],
            'telephone' => ['required', 'string', 'max:20'],
            'avatar' => ['image', 'mimes:jpg,jpeg,png,webp','max:2048']
        ]);

        if ($request->has('avatar'))
            UserController::upload_avatar($request, $restaurant->user);

        if( $request->name != $restaurant->user->name )
            UserController::_update($restaurant->user->id, $request->name, null);

        $restaurant->update([
            'nit' => $request->nit,
            'telephone' => $request->telephone
        ]);
    }

}
