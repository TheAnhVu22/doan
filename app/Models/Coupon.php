<?php

namespace App\Models;

use App\Models\base\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends BaseModel
{
    const DISCOUNT_BY_PERCENT = 1;

    const CASH_DISCOUNT = 2;

    const TYPE_DISCOUNT = [
        self::DISCOUNT_BY_PERCENT => 'Giảm theo %',
        self::CASH_DISCOUNT => 'Giảm theo số tiền VNĐ'
    ];

    protected $fillable = [
        'code',
        'name',
        'quantity',
        'type',
        'value',
        'start_date',
        'end_date',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'coupon_id', 'id');
    }
}
