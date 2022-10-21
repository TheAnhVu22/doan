<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Base\BaseRepository;

class PostRepository extends BaseRepository
{
    public function model()
    {
        return Post::class;
    }

    public function newInstance()
    {
        return new Post();
    }
}