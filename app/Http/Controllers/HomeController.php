<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\Comment;

class HomeController extends Controller
{
    
    public function index() 
    {
        // Retrieve posts from db sorted by id
        $posts = Post::orderBy('id', 'desc')->get();

        // Retrieve comments from db sorted by id 
        $comments = Comment::orderBy('id', 'desc')->get();
        
        // Return home page view and pass posts and comments to use in home page
        return view('pages.home', ['posts' => $posts, 'comments' => $comments]);
    }

    public function top() 
    {   
        // Set order of posts by votes from highest to lowest
        $posts = Post::orderBy('votes', 'desc')->get();

        // Retrieve comments from db sorted by id 
        $comments = Comment::orderBy('id', 'desc')->get();
        
        // Return home page view and pass posts and comments to use in home page
        return view('pages.home', ['posts' => $posts, 'comments' => $comments]);
    }

    public function upvote() 
    {
        // Retrieve post that is voted on from db by id 
        $post = Post::find(request()->id);

        // Retreive point, which determines if post is being upvoted or downvted, from view
        $point = request()->point;
        
        // Update votes value for post by value from view
        $post->votes = $post->votes + $point;

        // Save new updated post vote count value into db
        $post->save();

            
        // Get what type of vote was made to store in pivot table, post_user
        if (request()->voteType == "upvote") {
            $point = 1;
        } elseif (request()->voteType == "downvote") {
            $point = -1;
        } else {
            $point = 0;
        }

        // Update comment_user table or insert comment and vote relation if user has not voted on current comment before
        $post->users()->sync([Auth::User()->id => 
            [
                'vote' => $point
            ]
        ]);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
    
}
