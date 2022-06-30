<?php

namespace Ngeblog\Comment;

use Ngeblog\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Lara\Comment\Comment;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Ngeblog\User\Models\User  $user
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Comment $comment)
    {
        return $user->userComment->id == $comment->user_comment_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Ngeblog\User\Models\User  $user
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Comment $comment)
    {
        return $user->userComment->id == $comment->user_comment_id;
    }
}
