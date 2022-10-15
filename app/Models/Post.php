<?php

namespace App\Models;

use App\Models\base\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Post extends BaseModel
{
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
}
