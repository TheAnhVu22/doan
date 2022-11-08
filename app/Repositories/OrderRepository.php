<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Base\BaseRepository;
use Exception;
use Illuminate\Support\Facades\DB;

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

    public function cancelOrder(Order $order)
    {
        DB::beginTransaction();
        try {
            $shipping = $order->shipping;

            $order->orderDetails()->delete();
            $order->delete();
            $shipping->delete();
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }
        DB::commit();
        return true;
    }

    public function getOrderDeleted()
    {
        return $this->model->with('orderDetails', 'shipping', 'orderDetails.product')->withTrashed()->whereNotNull('deleted_at')->get();
    }
}
