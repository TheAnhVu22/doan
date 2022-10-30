<?php

namespace App\Models;

use App\Models\base\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class CategoryProduct extends BaseModel
{
    protected $fillable = [
        'name',
        'image',
        'slug',
        'description',
        'is_active'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
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
