<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function getUserName() {
        $user = User::where('id', $this->user_id)->get('username');

        return $user[0]->original['username'];
    }
}
