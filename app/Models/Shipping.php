<?php

namespace App\Models;

use App\Models\base\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shipping extends BaseModel
{
    protected $fillable = [
        'shipping_name',
        'shipping_phone',
        'shipping_address',
        'note',
        'payment_method'
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'shipping_id', 'id');
    }
}
