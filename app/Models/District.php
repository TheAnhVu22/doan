<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'district_name ',
        'type',
        'city_id'
    ];

    public function wards(): HasMany
    {
        return $this->hasMany(Wards::class, 'district_id', 'id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
}
