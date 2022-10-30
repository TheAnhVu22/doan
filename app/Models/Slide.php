<?php

namespace App\Models;

use App\Models\base\BaseModel;

class Slide extends BaseModel
{
    protected $fillable = [
        'name',
        'image'
    ];
}
