<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class CreateController extends Controller
{
    public function index() 
    { 
        return view('pages.create');
    }

    public function insert() 
    {
        $data = request()->validate([
            'content' => 'required',
            'author' => 'required',
            'url' => 'required'
        ]);

        $post = new \App\Post();

        $post->content = request('content');
        $post->author = request('author');
        $post->url = request('url');

        $post->save();

        return redirect("..\\");
    }
}
