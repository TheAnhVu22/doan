<?php

namespace App\Repositories;

use App\Models\Admin;
use App\Repositories\Base\BaseRepository;

class AdminRepository extends BaseRepository
{
    public function model()
    {
        return Admin::class;
    }

    public function newInstance()
    {
        return new Admin();
    }
}
