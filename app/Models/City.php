<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'city_name',
        'type'
    ];


    public function districts(): HasMany
    {
        return $this->hasMany(District::class, 'city_id', 'id');
    }
}
