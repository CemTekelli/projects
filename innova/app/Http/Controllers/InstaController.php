<?php

namespace App\Http\Controllers;

use App\Models\Insta;
use Illuminate\Http\Request;

class InstaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $instas = Insta::all();
        return view('admin.insta.main',compact('instas'));
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
        // $data = str_replace('&#8217;', "'", $request->feed);
        $insta = new Insta();
        $insta->feed = $request->feed;
        $insta->save();
        return redirect()->back()->with('succes', "new post add in your web site");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Insta  $insta
     * @return \Illuminate\Http\Response
     */
    public function show(Insta $insta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Insta  $insta
     * @return \Illuminate\Http\Response
     */
    public function edit(Insta $insta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Insta  $insta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Insta $insta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Insta  $insta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Insta $insta, Request $request)
    {
        $insta = Insta::find($request->id);
        $insta->delete();
        return redirect()->back()->with('warning', 'post delete in your web site');
    }
}
