<?php

namespace App\Repositories;

use App\Models\CategoryPost;
use App\Repositories\Base\BaseRepository;

class CategoryPostRepository extends BaseRepository
{
    public function model()
    {
        return CategoryPost::class;
    }

    public function newInstance()
    {
        return new CategoryPost();
    }

    public function all(array $columns = ['*'], array $relation = [])
    {
        return $this->model->with($relation)->ofIsActive()->get($columns);
    }
}