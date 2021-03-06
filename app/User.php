<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use DB;
use Carbon\Carbon;

class User extends Authenticatable
{
    // Any comment can have multiple people voting on it, so designating that relationship
    // many to many
    public function comments()
    {
        return $this->belongsToMany(Comment::class)->withPivot('vote');
    }

    /**
     * Grab the votes for any comment for any given user from pivot table
     *
     * @param user_id the user id as a fkt
     * @param comment_id the comment id as a fk 
     */
    public function getVoteForComment($user_id, $comment_id) {
        $vote = DB::table('comment_user')
                    ->where('user_id', $user_id)
                    ->where('comment_id', $comment_id)
                    ->get('vote');

        $vote = str_replace('[{"vote":', '', $vote);
        $vote = str_replace('}]', '', $vote);

        return $vote;
    }

    // Any post can have multiple people voting on it, so designating that relationship
    // many to many
    public function posts()
    {
        return $this->belongsToMany(Post::class)->withPivot('vote');
    }

    /**
     * Grab the votes for any comment for any given user from pivot table
     *
     * @param user_id the user id as a fk
     * @param post_id the post_id id as a fk 
     */
    public function getVoteForPost($user_id, $post_id) {
        $vote = DB::table('post_user')
                    ->where('user_id', $user_id)
                    ->where('post_id', $post_id)
                    ->get('vote');

        $vote = str_replace('[{"vote":', '', $vote);
        $vote = str_replace('}]', '', $vote);

        return $vote;
    }

    /**
     * Get the total post votes for a user
     */
    public function getTotalPostVotes() {
        $totalPostVotes = DB::table('posts')
                            ->where('author', $this->username)
                            ->sum('votes');
                           
        return $totalPostVotes;
    }

    /**
     * Get the total comment votes for a user
     */
    public function getTotalCommentVotes() {
        $totalCommentVotes = DB::table('comments')
                            ->where('user_id', $this->id)
                            ->sum('votes');
                           
        return $totalCommentVotes;
    }

    /**
     * Get the total number of days since account was created
     */
    public function getUserAccountAge() {
        $date = Carbon::parse($this->created_at);
        $now = Carbon::now();

        return $date->diffInDays($now);
    }

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
