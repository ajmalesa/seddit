<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class CommentController extends Controller
{
    
    public function index($id) 
    {
        $post = Post::find(request()->id);

        return view('pages.comment', ['post' => $post]);
    }

}
