<?php

namespace App\Models;

use App\Models\base\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends BaseModel
{
    protected $fillable = [
        'name',
    ];

    public function products(): BelongsToMany
    {
        return $this->BelongsToMany(
            Product::class,
            'product_tags',
            'tag_id',
            'product_id'
        )->withTimestamps();
    }
}
