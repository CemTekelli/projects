<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::all();
        return view('admin.comment.main', compact('comments'));
    }
    public function store(Request $request)
    {
        // dd($request);
        request()->validate([
            "name" => "required",
            "email" => "required|email",
            // "number" => "integer",
            "message" => "required",
        ]);
        $comment = new Comment();
        $comment->user = $request->name;
        $comment->email = $request->email;
        $comment->number = $request->number;
        $comment->commentaire = $request->message;
        $comment->product_id = $request->product_id;
        $comment->validate = false;
        $comment->date = now();
        $comment->save();
        return redirect()->to(url()->previous(). '#seed')->with('success', 'Commentaire posté !');
    }
}
