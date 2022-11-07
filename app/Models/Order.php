<?php

namespace App\Models;

use App\Models\base\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends BaseModel
{
    const PAYMENT_CASH = 1;

    const PAYMENT_EWALLET = 2;

    const PAYMENT_METHOD = [
        self::PAYMENT_CASH => 'Tiền mặt',
        self::PAYMENT_EWALLET => 'Ví điện tử'
    ];

    const STATUS_NEW = 1;

    const STATUS_PROCESSING = 2;

    const STATUS_COMPLETED = 3;

    const STATUS_ORDER = [
        self::STATUS_NEW => 'Đơn hàng mới',
        self::STATUS_PROCESSING => 'Đang xử lý',
        self::STATUS_COMPLETED => 'Đã hoàn thành',
    ];

    protected $fillable = [
        'user_id',
        'shipping_id',
        'order_code',
        'status',
        'coupon_id',
        'fee_ship'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function shipping(): BelongsTo
    {
        return $this->belongsTo(Shipping::class, 'shipping_id', 'id');
    }

    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class, 'coupon_id', 'id');
    }

    public function getStatusOrder($status)
    {
        return self::STATUS_ORDER[$status] ?? '';
    }

    public function scopeOfUser($query, $id)
    {
        return $query->where('user_id', $id);
    }

    public function scopeOfNewOrder($query)
    {
        return $query->where('status', self::STATUS_NEW);
    }

    public function scopeOfProcessOrder($query)
    {
        return $query->where('status', self::STATUS_PROCESSING);
    }

    public function scopeOfCompletedOrder($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }
}
