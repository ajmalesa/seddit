<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class HomeController extends Controller
{
    
    public function index() 
    {
        // Set default order to desc so newest posts are on top
        $defaultSort = 'desc';
        
        $posts = Post::orderBy('id', $defaultSort)->get();
        
        return view('pages.home', ['posts' => $posts]);
    }

    public function top() 
    {   
        $posts = Post::orderBy('votes', 'desc')->get();
        
        return view('pages.home', ['posts' => $posts]);
    }

    public function upvote() 
    {
        
        $post = Post::find(request()->id);
        $point = request()->point;
        
        $post->votes = $post->votes + $point;

        $post->save();

    }
}
