<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Repositories\Base\BaseRepository;

class TagRepository extends BaseRepository
{
    public function model()
    {
        return Tag::class;
    }

    public function newInstance()
    {
        return new Tag();
    }
}