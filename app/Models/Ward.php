<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ward extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'ward_name',
        'type',
        'district_id'
    ];

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }
}
