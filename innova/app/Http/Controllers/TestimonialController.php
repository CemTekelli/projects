<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testi = Testimonial::paginate(10);
        return view('admin.testi.main', compact('testi'));
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
        $testi = new Testimonial();
        $testi->user = $request->user;
        $testi->etoile = $request->etoile;
        $testi->avis = $request->avis;
        if ($request->file('img') != null) {
            $path = 'img/testi-img/';
            $file = $request->file('img');
            $new_image_name = 'UIMG'.date('Ymd').uniqid().'.jpg';
            $file->move(public_path($path), $new_image_name);
            $testi->img = $new_image_name;
        }
        $testi->save();
        return redirect()->back()->with('success', 'Review create ! ');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function show(Testimonial $testimonial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function edit(Testimonial $testimonial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $testimonial->user = $request->user;
        $testimonial->etoile = $request->etoile;
        $testimonial->avis = $request->avis;
        if ($request->file('img') != null) {
            if (File::exists(public_path('img/testi-img/' . $testimonial->img))) {
                $destination = "/img/testi-img/". $testimonial->img;
                Storage::disk('public')->delete($destination);
            }
            $path = 'img/testi-img/';
            $file = $request->file('img');
            $new_image_name = 'UIMG'.date('Ymd').uniqid().'.jpg';
            $file->move(public_path($path), $new_image_name);
            $testimonial->img = $new_image_name;
        } else if ($request->cbxTesti){
            // dd("/img/testi-img/". $testimonial->img);
            $destination = "/img/testi-img/". $testimonial->img;
            Storage::disk('public')->delete($destination);
            //delete DB
            $testimonial->img = NULL;
        }
        $testimonial->save();
        return redirect()->back()->with('success', 'Review update ! ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function destroy(Testimonial $testimonial)
    {
        $destination = "/img/testi-img/". $testimonial->img;
        Storage::disk('public')->delete($destination);
        $testimonial->delete();
        return redirect()->back()->with('warning', 'Review delete !');
    }
}
