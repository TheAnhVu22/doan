<?php

namespace App\Models;

use App\Models\base\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends BaseModel
{
    protected $fillable = [
        'name',
        'image',
        'product_id'
    ];

    public function product(): BelongsTo
    {
        return $this->BelongsTo(Product::class, 'product_id', 'id');
    }
}
