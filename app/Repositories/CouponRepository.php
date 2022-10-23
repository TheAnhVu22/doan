<?php

namespace App\Repositories;

use App\Models\Coupon;
use App\Repositories\Base\BaseRepository;

class CouponRepository extends BaseRepository
{
    public function model()
    {
        return Coupon::class;
    }

    public function newInstance()
    {
        return new Coupon();
    }
}