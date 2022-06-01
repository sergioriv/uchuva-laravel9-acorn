<?php

namespace App\Http\Controllers\branch;

use App\Http\Controllers\Controller;
use App\Http\Controllers\support\UserController;
use App\Models\Branch;
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
        return view('branch.tables.index');
    }

    public function data()
    {
        return ['data' => Table::where('branch_id', '=', $this->parents()[0]->id)->get()];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('branch.tables.create');
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

        $parents = $this->parents()[0];

        Table::create([
            'restaurant_id' => $parents->restaurant_id,
            'branch_id' => $parents->id,
            'reference' => $request->reference,
        ]);

        return redirect()->route('branch.tables.index')->with(
            ['notify' => 'success', 'title' => __('Table created!')],
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function show(Table $table)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function edit(Table $table)
    {
        return view('branch.tables.edit')->with('table', $table);
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

        return redirect()->route('branch.tables.index')->with(
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
