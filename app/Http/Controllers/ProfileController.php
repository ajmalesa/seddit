<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Comment;

class ProfileController extends Controller
{
    public function index($id) 
    {
        // Retrieve user from db by id passed from route
        $user = User::findOrFail(request()->id);

        // Retrieve posts from db by author name of post matching to username of user
        $posts = Post::where('author', $user->username)->get();

        // Retrieve comments from db by user_id 
        $comments = Comment::where('user_id', $id)->get();
        
        return view('pages.profile', [
            'user' => $user,
            'posts' => $posts,
            'comments' => $comments
        ]);
 

        
    }
}
