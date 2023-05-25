<?php

namespace App\Http\Controllers;

use App\Actions\CreatePoint;
use App\Actions\UpdatePoint;
use App\Models\Point;
use Illuminate\Http\Request;

class PointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $points = Point::orderByDesc('id')->get();

        return view('points._index', ['points' => $points]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('points._create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  CreatePoint  $createPoint
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CreatePoint $createPoint)
    {
        $point = $createPoint($request->all());

        return response()->turboStreamView(
            'points.turbo.created',
            ['point' => $point]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Point  $point
     * @return \Illuminate\Http\Response
     */
    public function show(Point $point)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Point  $point
     * @return \Illuminate\Http\Response
     */
    public function edit(Point $point)
    {
        return view('points._edit', ['point' => $point]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Point  $point
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Point $point, UpdatePoint $updatePoint)
    {
        $point = $updatePoint($request->all(), $point);

        return view('points._show', ['point' => $point]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Point  $point
     * @return \Illuminate\Http\Response
     */
    public function destroy(Point $point)
    {
        $point->delete();

        return response()->turboStream()->remove($point);
    }
}
