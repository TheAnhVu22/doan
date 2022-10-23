<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Repositories\Base\BaseRepository;

class CommentRepository extends BaseRepository
{
    public function model()
    {
        return Comment::class;
    }

    public function newInstance()
    {
        return new Comment();
    }
}