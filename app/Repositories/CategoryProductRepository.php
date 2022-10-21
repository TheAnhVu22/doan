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
}