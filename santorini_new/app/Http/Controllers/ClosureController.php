<?php

namespace App\Http\Controllers;

use App\Closure;
use App\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClosureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $closures = Closure::latest()->paginate(25);
//        $sales = Sale::all();
        $closures = DB::table('sales')
            ->select(DB::raw('date_format(created_at, "%D-%M-%Y") as created_at'), DB::raw('SUM(total_amount) as value'))
            ->groupBy(DB::raw('date_format(created_at, "%D-%M-%Y")'))
            ->paginate(25);


//        $closures->map(function ($position){
//            $position->last_seen=Carbon::parse($position->created_at)->diffForHumans();
//        });
//        select date_format(created_at, "%D-%M-%Y"), SUM(total_amount) from sales GROUP BY date_format(created_at, "%D-%M-%Y");

        return view('closure.index', compact('closures'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Closure  $closure
     * @return \Illuminate\Http\Response
     */
    public function show(Closure $closure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Closure  $closure
     * @return \Illuminate\Http\Response
     */
    public function edit(Closure $closure)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Closure  $closure
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Closure $closure)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Closure  $closure
     * @return \Illuminate\Http\Response
     */
    public function destroy(Closure $closure)
    {
        //
    }
}
