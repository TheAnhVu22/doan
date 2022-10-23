<?php

namespace App\Repositories;

use App\Models\CategoryProduct;
use App\Repositories\Base\BaseRepository;

class CategoryProductRepository extends BaseRepository
{
    public function model()
    {
        return CategoryProduct::class;
    }

    public function newInstance()
    {
        return new CategoryProduct();
    }

    public function all(array $columns = ['*'], array $relation = [])
    {
        return $this->model->with($relation)->ofIsActive()->get($columns);
    }
}
