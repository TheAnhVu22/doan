<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Base\BaseRepository;

class OrderRepository extends BaseRepository
{
    public function model()
    {
        return Order::class;
    }

    public function newInstance()
    {
        return new Order();
    }

    public function getOrderOfUser($user)
    {
        return $this->model->with('orderDetails', 'shipping', 'orderDetails.product')->where('user_id', $user->id)->get();
    }
}