<?php

namespace App\Models;

use App\Models\base\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends BaseModel
{
    protected $fillable = [
        'comment_parent_id',
        'name',
        'content',
        'product_id'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
