<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use DB;

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
