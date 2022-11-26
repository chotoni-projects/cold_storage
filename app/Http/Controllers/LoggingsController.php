<?php

namespace App\Http\Controllers;

use App\Models\Logging;
use Illuminate\Http\Request;


class LoggingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        if( $from && $to ) {
            $logging = Logging::whereBetween('created_at', [$from, $to])->orderBy('created_at', 'desc')->latest()->get();
        } else {
            $logging = Logging::orderBy('created_at', 'desc')->latest()->limit(1000)->get();
            
        }
        return $logging->toArray();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
     * @param  \App\Models\Logging  $logging
     * @return \Illuminate\Http\Response
     */
    public function show(Logging $logging)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Logging  $logging
     * @return \Illuminate\Http\Response
     */
    public function edit(Logging $logging)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Logging  $logging
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Logging $logging)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Logging  $logging
     * @return \Illuminate\Http\Response
     */
    public function destroy(Logging $logging)
    {
        //
    }
}
