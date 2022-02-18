<?php

namespace App\Http\Controllers;

use App\Mail\ContactSender;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contact = Contact::all();
        // close email
        $count_close = [];
        foreach ($contact as $value) {
            if ($value->open === 0) {
                array_push($count_close, $value);
            }
        }
        // email moving
        $mail_moving = [];
        foreach ($contact as $value) {
            if ($value->type === "moving") {
                array_push($mail_moving, $value);
            }
        }
        // email furniture
        $mail_furniture = [];
        foreach ($contact as $value) {
            if ($value->type === "furniture") {
                array_push($mail_furniture, $value);
            }
        }
        return view('admin.contact.main', compact('contact', 'count_close', 'mail_moving', 'mail_furniture'));
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
        // if (! Gate::allows('mail-post', $request)) {
        //     // dd('test');
        //     abort(403);
        // }
        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->subject = $request->subject;
        $contact->message = $request->message;
        $contact->open = false;
        $contact->type = $request->type;
        $contact->save();
        Mail::to('info@innovafurniture.be')->send(new ContactSender($request));
        return redirect()->back()->with('success', 'Sent message');
        // return redirect()->to(url()->previous() . '#movingContact')->with('success', 'Sent message');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = Contact::find($id);
        $contact->delete();
        return redirect()->back()->with("warning", "message delete");
    }
}
