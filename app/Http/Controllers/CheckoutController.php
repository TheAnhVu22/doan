<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutStoreRequest;
use App\Models\City;
use App\Models\District;
use App\Models\Ward;
use App\Repositories\ProductRepository;
use App\Services\CheckoutService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    protected $productRepo;
    protected $checkoutService;

    public function __construct(
        ProductRepository $productRepository,
        CheckoutService $CheckoutService,
    ) {
        $this->productRepo = $productRepository;
        $this->checkoutService = $CheckoutService;
    }

    public function showCart()
    {
        $carts = \Session::has('cart') ? \Session::get('cart') : [];
        return view('user.checkout.cart', compact('carts'));
    }

    public function addProductToCard(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'product_id' => 'required|exists:products,id',
                'product_name' => 'required|exists:products,name',
                'product_price' => 'required|integer',
                'product_quantity' => 'required|integer',
                'product_image' => 'nullable|string',
                'product_qty' => 'required|integer|gt:0|max:10',
            ]
        );

        if ($validator->passes()) {
            return $this->checkoutService->addCart($request->all());
        }

        return response()->json(['error' => 'Có lỗi xảy ra']);
    }

    public function updateQuantity(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'product' => 'required|string|max:5',
                'quantity' => 'required|integer|gt:0|max:5'
            ]
        );

        if ($validator->passes()) {
            $result = $this->checkoutService->updateCart($request->all());
            if ($result !== false) {
                return view('user.checkout.table_cart', ['carts' => $result]);
            } else {
                return response()->json(['error' => 'Có lỗi xảy ra']);
            }
        }

        return response()->json(['error' => 'Có lỗi xảy ra']);
    }

    public function deleteProductInCart(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'product' => 'required|string|max:5',
            ]
        );

        if ($validator->passes()) {
            $result = $this->checkoutService->removeCart($request->all());
            if ($result !== false) {
                return view('user.checkout.table_cart', ['carts' => $result]);
            } else {
                return response()->json(['error' => 'Có lỗi xảy ra']);
            }
        }

        return response()->json(['error' => 'Có lỗi xảy ra']);
    }

    public function checkoutForm(Request $request)
    {
        $carts = \Session::get('cart');
        $cities = City::all();
        $districts = [];
        $wards = [];
        $feeShip = 0;
        $discount = 0;
        $couponCode = '';

        if ($request->ajax()) {
            $data = $request->all();

            if ($data['action']) {
                if ($data['action'] === "city") {
                    $districts = District::where('city_id', $data['id'])->get();
                    return view('admin.layouts.select_district', compact('districts'));
                } else {
                    $wards = Ward::where('district_id', $data['id'])->get();
                    return view('admin.layouts.select_ward', compact('wards'));
                }
            }
        }
        return view('user.checkout.checkout', compact('carts', 'cities', 'districts', 'wards', 'feeShip', 'discount', 'couponCode'));
    }

    public function applyCoupon(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'code' => 'required|string|exists:coupons,code',
                'total' => 'required',
                'feeShip' => 'nullable',
            ],
            [
                'code.required' => 'Nhập mã giảm giá',
                'code.exists' => 'Mã giảm giá không đúng',
            ]
        );

        if ($validator->passes()) {
            $coupon = $this->checkoutService->applyCoupon($request->all());
            if ($coupon !== false) {
                $discount = $coupon['coupon_type'] == '1'
                    ? ($request['total'] * ($coupon['coupon_value'] / 100))
                    : ($request['total'] - $coupon['coupon_value']);
                $feeShip = $request->feeShip;
                $couponCode = $coupon['coupon_code'];
                $carts = \Session::get('cart');
                return view('user.checkout.table_checkout', compact('feeShip', 'carts', 'discount', 'couponCode'));
            } else {
                return response()->json(['error' => 'Mã giảm giá không đúng!']);
            }
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function applyFeeship(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'city' => 'required|exists:cities,id',
                'district' => 'required|exists:districts,id',
                'ward' => 'required|exists:wards,id',
                'discount' => 'nullable|integer',
                'couponCode' => 'nullable'
            ]
        );

        if ($validator->passes()) {
            $feeShip = $this->checkoutService->applyFeeship($request->all());
            $carts = \Session::get('cart');
            $couponCode = $request->coupon_code;
            $discount = $request->discount;
            return view('user.checkout.table_checkout', compact('feeShip', 'carts', 'discount', 'couponCode'));
        }

        return response()->json(['error' => 'Có lỗi xảy ra khi tính phí vận chuyển']);
    }

    public function checkoutStore(CheckoutStoreRequest $request)
    {
        $parrams = $request->validated();
        $result = $this->checkoutService->checkoutStore($parrams);
        if ($result) {
            return redirect()->route('manager_order', ['user' => \Auth::guard('user')->user()])->with('status', 'Đặt hàng thành công!');
        } else {
            return back()->withErrors('Có lỗi xảy ra!');
        }
    }

    public function cancelOrder(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'order_code' => 'required|exists:orders,order_code',
                'reason' => 'required|max:200',
                'user_id' => 'required|exists:users,id',
            ]
        );

        if ($validator->passes()) {
            $result = $this->checkoutService->cancelOrder($request->all());
            if ($result === true) {
                return 'Hủy đơn hàng thành công!';
            } else {
                return response()->json(['error' => 'Có lỗi xảy ra, hủy đơn không thành công']);
            }
        }

        return response()->json(['error' => 'Thông tin không chính xác']);
    }
}
