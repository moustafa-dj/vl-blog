<?php

namespace App\Repositories;

use App\Contracts\CommentContract;
use App\Models\Comment;

class CommentRepository extends BaseRepository implements CommentContract
{
    public function __construct(Comment $model)
    {
        $this->model = $model;
    }

}