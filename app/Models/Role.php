<?php

namespace App\Models;

use App\Models\base\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends BaseModel
{
    protected $fillable = [
        'name'
    ];

    public function admins(): HasMany
    {
        return $this->hasMany(Admin::class, 'role_id', 'id');
    }
}
