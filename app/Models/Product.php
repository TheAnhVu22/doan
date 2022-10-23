<?php

namespace App\Models;

use App\Models\base\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends BaseModel
{

    const ACCESSORIES = [
        10 => 'Sạc, cáp',
        20 => 'Bàn phím',
        30 => 'Chuột',
        40 => 'Thẻ nhớ',
        50 => 'USB',
        60 => 'SSD'
    ];

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

    public function tags(): BelongsToMany
    {
        return $this->BelongsToMany(
            Tag::class,
            'product_tags',
            'product_id',
            'tag_id'
        )->withTimestamps();
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function scopeOfIsActive($query)
    {
        return $query->where('is_active', 1);
    }
}
