<?php

namespace App\Http\Controllers;

use App\Models\Partener;
use Illuminate\Http\Request;

class PartenerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parteners = Partener::all();
        return view('admin.parteners.main', compact('parteners'));
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
        // dd('test');
        $path = 'img/partners/';
        $file = $request->file('image');
        $new_image_name = 'UIMG'.date('Ymd').uniqid().'.jpg';
        $file->move(public_path($path), $new_image_name);

        $partener = new Partener();
        $partener->img = $new_image_name;
        $partener->save();
        return redirect()->back()->with('success', 'upload');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Partener  $partener
     * @return \Illuminate\Http\Response
     */
    public function show(Partener $partener)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Partener  $partener
     * @return \Illuminate\Http\Response
     */
    public function edit(Partener $partener)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Partener  $partener
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Partener $partener)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Partener  $partener
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $partener = Partener::find($request->id);
        $partener->delete();
        return redirect()->back()->with('warning', 'delete');
    }
}
