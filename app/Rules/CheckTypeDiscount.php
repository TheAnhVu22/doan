<?php

namespace App\Rules;

use App\Models\Coupon;
use Illuminate\Contracts\Validation\Rule;

class CheckTypeDiscount implements Rule
{
    private $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function passes($attribute, $value)
    {
        if ($this->type == Coupon::DISCOUNT_BY_PERCENT) {
            if ($value <= 100) {
                return true;
            }
            return false;
        }

        return true;
    }

    public function message()
    {
        return 'Giảm tối đa 100%';
    }
}
