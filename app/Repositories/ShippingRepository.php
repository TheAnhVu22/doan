<?php

namespace App\Repositories;

use App\Models\Shipping;
use App\Repositories\Base\BaseRepository;

class ShippingRepository extends BaseRepository
{
    public function model()
    {
        return Shipping::class;
    }

    public function newInstance()
    {
        return new Shipping();
    }
}