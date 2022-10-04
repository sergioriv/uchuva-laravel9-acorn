<?php

namespace App\Http\Controllers\restaurant;

use App\Http\Controllers\Controller;
use App\Http\Controllers\support\UserController;
use App\Models\Branch;
use App\Models\Restaurant;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TableController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:tables');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('restaurant.tables.index', [
            'tables' => Table::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('restaurant.tables.create');
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
            'reference' => ['required', 'string', 'max:3']
        ]);

        Table::create([
            'restaurant_id' => $this->restaurant(),
            'reference' => $request->reference,
        ]);

        return redirect()->route('restaurant.tables.index')->with(
            ['notify' => 'success', 'title' => __('Table created!')],
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function edit(Table $table)
    {
        return view('restaurant.tables.edit', ['table' => $table]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Table $table)
    {
        $request->validate([
            'reference' => ['required', 'string', 'max:3']
        ]);

        $table->update([
            'reference' => $request->reference
        ]);

        return redirect()->route('restaurant.tables.index')->with(
            ['notify' => 'success', 'title' => __('Table updated!')],
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function destroy(Table $table)
    {
        if ( $table->orders->count() > 0 ) {
            return redirect()->back()->with(
                ['notify' => 'fail', 'title' => __('Not allowed')],
            );
        }

        $table->delete();

        return redirect()->route('restaurant.tables.index')->with(
            ['notify' => 'success', 'title' => __('Table deleted!')],
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
