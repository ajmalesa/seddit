<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;
use App\Sub;

class SubController extends Controller
{
    public function index($sub) 
    {
        // Get sub id based on name
        $subId = Sub::where('name', $sub)
                        ->value('id');

        // Get total number of posts so we can show next button if there are more
        // posts than currently being displayed on page
        $postCount = Post::all()->count();

        // Retrieve posts from db sorted by id
        $posts = Post::orderBy('id', 'desc')
                        ->limit(10)
                        ->where('sub_id', $subId)
                        ->get();

        // Retrieve comments from db sorted by id 
        $comments = Comment::orderBy('id', 'desc')->get();
        
        // Return home page view and pass posts and comments to use in home page
        return view('pages.home', [ 
                        'posts' => $posts, 
                        'comments' => $comments,                        
                        'postCount' => $postCount,
                        'page' => 1
                    ]);
    }
}
