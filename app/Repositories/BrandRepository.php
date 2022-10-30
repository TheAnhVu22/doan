<?php

namespace App\Repositories;

use App\Models\BrandProduct;
use App\Repositories\Base\BaseRepository;

class BrandRepository extends BaseRepository
{
    public function model()
    {
        return BrandProduct::class;
    }

    public function newInstance()
    {
        return new BrandProduct();
    }

    public function all(array $columns = ['*'], array $relation = [])
    {
        return $this->model->with($relation)->ofIsActive()->get($columns);
    }

    public function getBrand()
    {
        return $this->model->take(4)->get();
    }
}