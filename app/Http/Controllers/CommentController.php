<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;

class CommentController extends Controller
{
    
    public function index($id) 
    {
        // Set default order to desc so newest posts are on top
        $defaultSort = 'desc';

        // Retrieve post from db by id passed from route, which was originally passed from view
        $post = Post::findOrFail(request()->id);

        // Retrieve comments from db, ordered by default sort from above and id passsed from view
        $comments = Comment::orderBy('id', $defaultSort)->where('post_id', $id)->get();

        // Return view to display clicked post by id and display all comments for said post
        return view('pages.comment', ['post' => $post, 'comments' => $comments]);
    }

    public function top($id) 
    {   
        // Set order of posts by votes from highest to lowest
        $comments = Comment::orderBy('votes', 'desc')->where('post_id', $id)->get();

        // Retrieve post from db by id passed from route, which was originally passed from view
        $post = Post::find(request()->id);
        
        // Return home page view and pass posts to use in home page
        return view('pages.comment', ['post' => $post, 'comments' => $comments]);
    }

    public function reply()
    {
        // Make new comment record for db
        $comment = new \App\Comment();
        
        // Populate comment fields using values from view
        $comment->comment = request('comment');
        $comment->user_id = request('user_id');
        $comment->replied_to_id = request('replied_to_id');
        $comment->post_id = request('post_id');
        
        // Save comment to database
        $comment->save();

        // Redirect to current page after updating db so user can see their comment displayed
        return redirect("/comment/" . request('post_id'));
    }

    public function upvote()
    {
        // Retrieve comment from db by id passed from view
        $comment = Comment::find(request()->id);
        
        // Retrieve point value from view to increment or decrement db value by
        $point = request()->point;

        // Update votes value for comment by value from view
        $comment->votes = $comment->votes + $point;

        // Save new updated comment vote count value into db
        $comment->save();
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
