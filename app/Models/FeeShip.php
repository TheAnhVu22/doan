<?php

namespace App\Models;

use App\Models\base\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeeShip extends BaseModel
{
    protected $fillable = [
        'city_id',
        'district_id',
        'ward_id',
        'fee_ship',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function ward(): BelongsTo
    {
        return $this->belongsTo(Ward::class, 'ward_id');
    }
}
