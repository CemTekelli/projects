<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faq = Faq::paginate(10);
        return view('admin.faq.main', compact('faq'));
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
        $faq = new Faq();
        $faq->ask = $request->ask;
        $faq->reponse = $request->reponse;
        $faq->ask_fr = $request->ask_fr;
        $faq->reponse_fr = $request->reponse_fr;
        $faq->ask_en = $request->ask_en;
        $faq->reponse_en = $request->reponse_en;
        $faq->save();
        return redirect()->back()->with('success', 'Ask create ! ');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function show(Faq $faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function edit(Faq $faq)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faq $faq)
    {
        $faq->ask = $request->ask;
        $faq->reponse = $request->reponse;
        $faq->ask_fr = $request->ask_fr;
        $faq->reponse_fr = $request->reponse_fr;
        $faq->ask_en = $request->ask_en;
        $faq->reponse_en = $request->reponse_en;
        $faq->save();
        return redirect()->back()->with('success', 'Ask update ! ');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->back()->with('warning', 'Ask delete !');

    }
}
