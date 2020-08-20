<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function getUserName() {
        $user = User::where('id', $this->user_id)->get('username');

        return $user[0]->original['username'];
    }

    public function checkIfExists($id) {
        return Comment::select('id')->where('replied_to_id', $id)->exists();
    }

    public function getReplyByCommentById($id) {

        return Comment::orderBy('created_at', 'DESC')->where('replied_to_id', $id)->get();
    }

    public function makeClickableLinks($comment) {
        return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $comment);
    }
}
