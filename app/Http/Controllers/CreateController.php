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
        // Validate data from view to make sure we got all needed fields for db
        $data = request()->validate([
            'content' => 'required',
            'author' => 'required',
            'url' => 'required'
        ]);

        // Create new post record for db
        $post = new \App\Post();

        // Populate post fields with data from view
        $post->content = request('content');
        $post->author = request('author');
        $post->url = request('url');

        // Save post to db
        $post->save();

        // Return to home page 
        return redirect("/");
    }

    
    public function delete() 
    {
        // Retrieve post from db by id passed from view
        $post = Post::find(request()->id);

        // Delete post from db
        $post->delete();

        // Return to home page
        return redirect("/");
    }

}
