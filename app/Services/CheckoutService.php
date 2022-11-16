<?php

namespace App\Services;

use App\Mail\MailNotifyOrder;
use App\Models\City;
use App\Models\Coupon;
use App\Models\District;
use App\Models\FeeShip;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\Ward;
use Exception;
use Illuminate\Support\Facades\DB;
use Mail;

class CheckoutService
{
    public function addCart($request)
    {
        DB::beginTransaction();
        try {
            $product = Product::find($request['product_id']);
            $session_id = substr(md5(microtime()), rand(0, 26), 5);
            $cart = \Session::get('cart');
            if ($cart == true) {
                $isProductNotInCart = true;
                foreach ($cart as $productCart) {
                    if ($productCart['product_id'] === $request['product_id']) {
                        $isProductNotInCart = false;
                        break;
                    }
                }
                if ($isProductNotInCart) {
                    $cart[] = array(
                        'session_id' => $session_id,
                        'product_id' => $request['product_id'],
                        'product_name' => $request['product_name'],
                        'product_image' => $request['product_image'],
                        'product_price' => $product->price * (1 - (($product->discount) / 100)),
                        'product_quantity' => $request['product_quantity'],
                        'product_qty' => $request['product_qty'],
                    );
                    \Session::put('cart', $cart);
                }
            } else {
                $cart[] = array(
                    'session_id' => $session_id,
                    'product_name' => $request['product_name'],
                    'product_id' => $request['product_id'],
                    'product_image' => $request['product_image'],
                    'product_quantity' => $request['product_quantity'],
                    'product_qty' => $request['product_qty'],
                    'product_price' => $product->price * (1 - (($product->discount) / 100))
                );
                \Session::put('cart', $cart);
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
            $cart = \Session::get('cart');
            if ($cart == true) {
                foreach ($cart as $key => $product) {
                    if ($product['session_id'] == $request['product']) {
                        unset($cart[$key]);
                    }
                }
                \Session::put('cart', $cart);
            } else {
                return false;
            }
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }
        DB::commit();
        return \Session::get('cart') ?? [];
    }

    public function updateCart($request)
    {
        DB::beginTransaction();
        try {
            $cart = \Session::get('cart');
            if ($cart == true) {
                foreach ($cart as $key => $product) {
                    if ($product['session_id'] == $request['product']) {
                        $cart[$key]['product_qty'] = $request['sales_quantity'];
                    }
                }
                \Session::put('cart', $cart);
            } else {
                return false;
            }
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }
        DB::commit();
        return \Session::get('cart') ?? [];
    }


    public function applyCoupon($request)
    {
        DB::beginTransaction();
        try {
            $now = \Carbon\Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
            $coupon = Coupon::where('code', $request['code'])->whereDate('start_date', '<=', $now)
                ->whereDate('end_date', '>=', $now)->where('quantity', '>', 0)->first();
            if ($coupon) {
                $isCouponUsed = Order::where('user_id', \Auth::guard('user')->user()->id)
                    ->where('coupon_id', $coupon->id)->first();
                if (!$isCouponUsed) {
                    $coupon_code = array(
                        'coupon_code' => $coupon->code,
                        'coupon_type' => $coupon->type,
                        'coupon_value' => $coupon->value,
                    );
                    \Session::put('coupon', $coupon_code);
                } else {
                    return 1;
                }
            } else {
                return 2;
            }
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }
        DB::commit();
        return \Session::get('coupon') ?? 2;
    }

    public function applyFeeship($request)
    {
        DB::beginTransaction();
        try {
            $feeShip = FeeShip::where('city_id', $request['city'])->where('district_id', $request['district'])
                ->where('ward_id', $request['ward'])->first();
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }
        DB::commit();

        if ($feeShip) {
            return $feeShip->fee_ship;
        } else {
            return '50000';
        }
    }

    public function checkoutStore($request)
    {
        DB::beginTransaction();
        try {
            $now = \Carbon\Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
            $coupon = Coupon::where('code', $request['coupon_code'])->whereDate('start_date', '<=', $now)
                ->whereDate('end_date', '>=', $now)->where('quantity', '>', 0)->first();

            if ($coupon) {
                $coupon->decrement('quantity');
                $coupon->save();
            }

            $city = City::findOrFail($request['city_id']);
            $district = District::findOrFail($request['district_id']);
            $ward = Ward::findOrFail($request['ward_id']);

            $request['shipping_address'] = $ward->ward_name . ', ' . $district->district_name . ', ' . $city->city_name;

            $shipping = Shipping::Create($request);

            $order_code = substr(md5(microtime()), rand(0, 26), 6);


            $order = new Order();
            $order->user_id = \Auth::guard('user')->user()->id;
            $order->shipping_id = $shipping->id;
            $order->order_code = $order_code;
            $order->status = 1;
            $order->coupon_id =  $coupon?->id;
            $order->fee_ship = $request['feeShip'];
            $order->save();

            if (\Session::get('cart') == true) {
                foreach (\Session::get('cart') as $key => $cart) {
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

            $email = \Auth::guard('user')->user()->email;
            $linkManagerOrder = url('/manager-order/' .  \Auth::guard('user')->user()->id);
            $emailInfo = array(
                'email' => $email,
                'link' => $linkManagerOrder,
            );
            \Mail::to($email)->send(new MailNotifyOrder($emailInfo));

            \Session::forget('cart');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }
        DB::commit();
        return true;
    }

    public function cancelOrder($request)
    {
        DB::beginTransaction();
        try {
            $order = Order::where('order_code', $request['order_code'])->ofNewOrder()->ofUser($request['user_id'])->first();
            if ($order) {

                $shipping = $order->shipping;
                $order->coupon->increment('quantity');
                $order->coupon->save();
                $order->orderDetails()->delete();
                $order->delete();

                $shipping->note = $request['reason'];
                $shipping->save();
                $shipping->delete();
            } else {
                return false;
            }
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }
        DB::commit();
        return true;
    }
}
