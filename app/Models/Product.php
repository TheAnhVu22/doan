<?php

namespace App\Models;

use App\Models\base\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends BaseModel
{
    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'description',
        'price',
        'tags',
        'quantity',
        'views',
        'is_active'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(CategoryProduct::class, 'category_id', 'id');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(BrandProduct::class, 'brand_id', 'id');
    }

    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'product_id', 'id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'product_id', 'id');
    }

    public function productImages(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
}
