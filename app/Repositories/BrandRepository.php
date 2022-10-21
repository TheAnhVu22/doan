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
}