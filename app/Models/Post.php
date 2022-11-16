<?php

namespace App\Models;

use App\Models\base\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Post extends BaseModel
{
    const POLICIES = [
        'Quy định chung' => 'quy-dinh-chung',
        'Chính sách giao hàng' => 'chinh-sach-giao-hang',
        'Chính sách bảo hành' => 'chinh-sach-bao-hanh',
        'Chính sách đổi trả' => 'chinh-sach-doi-tra',
    ];

    protected $table = 'posts';

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'image',
        'author_name',
        'views',
        'is_active'
    ];

    public function categoryPost(): BelongsTo
    {
        return $this->belongsTo(CategoryPost::class, 'category_id', 'id');
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
