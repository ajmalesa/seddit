<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class Post extends Model
{
    public function users() {
        return $this->belongsToMany(User::class);
    }

    /**
     * Grab the userID for a post by the author name
     *
     * @param author the name of the author for the given post
     */
    public function getUserIDByAuthorName($author) {
        $userID = DB::table('users')
            ->where('username', $author)
            ->get('id');

        $userID = str_replace('[{"id":', '', $userID);
        $userID = str_replace('}]', '', $userID);

        return $userID;
    }
}
