<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Foreach_;

class AdminController extends Controller
{
    public function admin()
    {
        $products = Product::all();
        $comments = Comment::all();
        $users = User::all();
        return view('admin.dashboard', compact('users', 'comments', 'products'));
    }
    public function users()
    {
        return view('admin/users/main');
    }
}
