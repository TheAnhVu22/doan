<?php

namespace App\Repositories;

use App\Models\City;
use App\Models\District;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\Ward;
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
            foreach($order->orderDetails as $orderDetail){
                $orderDetail->product->increment('quantity', $orderDetail->sales_quantity);
                $orderDetail->product->save();
            }
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

    public function addCart($request)
    {
        DB::beginTransaction();
        try {
            $product = Product::find($request['product_id']);
            $session_id = substr(md5(microtime()), rand(0, 26), 5);
            $cart = \Session::get('admin_cart');
            if ($cart == true) {
                $isProductNotInCart = true;
                foreach ($cart as $pro) {
                    if ($pro['product_id'] === $product->id) {
                        $isProductNotInCart = false;
                        break;
                    }
                }
                if ($isProductNotInCart) {
                    $cart[] = array(
                        'session_id' => $session_id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'product_image' => optional($product->productImages)[0]?->image,
                        'product_price' => $product->price * (1 - (($product->discount) / 100)),
                        'product_quantity' => $product->quantity,
                        'product_qty' => 1,
                    );
                    \Session::put('admin_cart', $cart);
                }
            } else {
                $cart[] = array(
                    'session_id' => $session_id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_image' => optional($product->productImages)[0]?->image,
                    'product_price' => $product->price * (1 - (($product->discount) / 100)),
                    'product_quantity' => $product->quantity,
                    'product_qty' => 1,
                );
                \Session::put('admin_cart', $cart);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }
        DB::commit();
        return true;
    }

    public function removeCart($request)
    {
        DB::beginTransaction();
        try {
            $cart = \Session::get('admin_cart');
            if ($cart == true) {
                foreach ($cart as $key => $product) {
                    if ($product['session_id'] == $request['product']) {
                        unset($cart[$key]);
                    }
                }
                \Session::put('admin_cart', $cart);
            } else {
                return false;
            }
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }
        DB::commit();
        return \Session::get('admin_cart') ?? [];
    }

    public function updateCartAdmin($request)
    {
        DB::beginTransaction();
        try {
            $cart = \Session::get('admin_cart');
            if ($cart == true) {
                foreach ($cart as $key => $product) {
                    if ($product['session_id'] == $request['product']) {
                        $cart[$key]['product_qty'] = $request['quantity'];
                    }
                }
                \Session::put('admin_cart', $cart);
            } else {
                return false;
            }
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }
        DB::commit();
        return \Session::get('admin_cart') ?? [];
    }

    public function createOrder($request)
    {
        DB::beginTransaction();
        try {
            $now = \Carbon\Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

            $city = City::findOrFail($request['city_id']);
            $district = District::findOrFail($request['district_id']);
            $ward = Ward::findOrFail($request['ward_id']);

            $request['shipping_address'] = $ward->ward_name . ', ' . $district->district_name . ', ' . $city->city_name;

            $shipping = Shipping::Create($request);

            $order_code = substr(md5(microtime()), rand(0, 26), 6);

            $order = new Order();
            $order->shipping_id = $shipping->id;
            $order->order_code = $order_code;
            $order->status = 1;
            $order->fee_ship = $request['feeShip'];
            $order->save();

            if (\Session::get('admin_cart') == true) {
                foreach (\Session::get('admin_cart') as $key => $cart) {
                    $pro = Product::find($cart['product_id']);
                    if ($pro->quantity < $cart['product_qty']) {
                        return false;
                    }
                    $order_details = new OrderDetail();
                    $order_details->order_id = $order->id;
                    $order_details->product_id = $cart['product_id'];
                    $order_details->price = $cart['product_price'];
                    $order_details->sales_quantity = $cart['product_qty'];
                    $order_details->save();

                    $pro->decrement('quantity', $cart['product_qty']);
                    $pro->save();
                }
            }

            \Session::forget('admin_cart');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }
        DB::commit();
        return true;
    }

    public function updateOrder($order, $params)
    {
        DB::beginTransaction();
        try {
            $shipping = $order->shipping;
            $shipping->update($params);
            $order->update($params);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }
        DB::commit();
        return true;
    }
}
