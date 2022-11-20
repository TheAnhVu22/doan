<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Models\City;
use App\Models\District;
use App\Models\Order;
use App\Models\Ward;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Services\CheckoutService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected $orderRepo;
    protected $checkoutService;
    protected $productRepo;

    public function __construct(
        CheckoutService $CheckoutService,
        OrderRepository $orderRepository,
        ProductRepository $productRepository
    ) {
        $this->orderRepo = $orderRepository;
        $this->checkoutService = $CheckoutService;
        $this->productRepo = $productRepository;
    }

    public function index(Request $request)
    {
        if ($request->isDeleted) {
            $orders =  $this->orderRepo->getOrderDeleted();
        } else {
            $orders =  $this->orderRepo->all();
        }

        return view('admin.order.index', compact('orders'));
    }

    public function create(Request $request)
    {
        $cities = City::all();
        $feeShip = 0;
        $districts = [];
        $wards = [];
        $carts = [];
        $products =  $this->productRepo->getAll(['*'], ['category', 'brand']);
        $order = $this->orderRepo->newInstance();
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
        } else {
            \Session::has('admin_cart') ? \Session::forget('admin_cart') : '';
        }
        return view('admin.order.create', compact('order', 'products', 'cities', 'districts', 'wards', 'feeShip', 'carts'));
    }

    public function store(OrderStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->validated();
            $this->orderRepo->createOrder($params);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }

        DB::commit();
        return redirect()->route('order.index')->with('status', 'Thêm Đơn Hàng Thành Công');
    }

    public function show($id)
    {
        $order = $this->orderRepo->findWithTrashed($id);
        return view('admin.order.detail', compact('order'));
    }

    public function edit(Order $order)
    {
        $cities = City::all();
        $districts = [];
        $wards = [];
        if ($order->status === Order::STATUS_COMPLETED) {
            abort(404);
        }
        return view('admin.order.edit', compact('order', 'cities', 'districts', 'wards'));
    }

    public function update(OrderUpdateRequest $request, Order $order)
    {
        DB::beginTransaction();
        try {
            $params = $request->validated();
            $this->orderRepo->updateOrder($order, $params);
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }

        DB::commit();
        return redirect()->route('order.index')->with('status', 'Cập Nhật Đơn Hàng Thành Công');
    }

    public function destroy(Order $order)
    {
        try {
            if ($order->status === Order::STATUS_NEW && $order->shipping?->payment_method === \App\Models\Order::PAYMENT_CASH) {
                $this->orderRepo->cancelOrder($order);
            } else {
                return back()->withErrors('Không thể hủy đơn đã được duyệt hoặc đã được thanh toán!');
            }
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }

        return redirect()->route('order.index')->with('status', 'Hủy Đơn Đặt Hàng Thành Công');
    }

    public function confirmOrder(Request $request)
    {
        $order =  $this->orderRepo->search($request->order_code, 'order_code', ['orderDetails', 'shipping', 'orderDetails.product']);
        if (!$order || $order->status !== Order::STATUS_NEW) {
            return back()->withErrors('Xác nhận đơn hàng thất bại');
        }
        $order->status = Order::STATUS_PROCESSING;
        $order->save();
        return redirect()->route('order.index')->with('status', 'Xác Nhận Đơn Đặt Hàng Thành Công');
    }

    public function applyFeeshipAdmin(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'city' => 'required|exists:cities,id',
                'district' => 'required|exists:districts,id',
                'ward' => 'required|exists:wards,id',
            ]
        );

        if ($validator->passes()) {
            $feeShip = $this->checkoutService->applyFeeship($request->all());
            $carts = \Session::get('admin_cart');
            return view('admin.order.table_product_create', compact('feeShip', 'carts'));
        }

        return response()->json(['error' => 'Có lỗi xảy ra khi tính phí vận chuyển']);
    }

    public function searchProductModal(Request $request)
    {
        $products = $request['keywords'] !== 'all'
            ? $this->productRepo->searchProduct($request)
            : $this->productRepo->getAll(['*'], ['category', 'brand']);
        return view('admin.order.table_all_product', compact('products'));
    }

    public function addProductOrder(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'product_id' => 'required|exists:products,id',
                'feeShip' => 'required'
            ]
        );

        if ($validator->passes()) {
            $result = $this->orderRepo->addCart($request->all());
            if ($result == true) {
                $carts = \Session::get('admin_cart');
            } else {
                return response()->json(['error' => 'Có lỗi xảy ra!']);
            }
            $feeShip = $request->feeShip;
            return view('admin.order.table_product_create', compact('carts', 'feeShip'));
        }

        return response()->json(['error' => 'Có lỗi xảy ra!']);
    }

    public function removeProductAdminCart(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'product' => 'required|string|max:5',
                'feeShip' => 'required'
            ]
        );

        if ($validator->passes()) {
            $result = $this->orderRepo->removeCart($request->all());
            if ($result !== false) {
                $feeShip = $request->feeShip;
                return view('admin.order.table_product_create', ['carts' => $result, 'feeShip' => $feeShip]);
            } else {
                return response()->json(['error' => 'Có lỗi xảy ra']);
            }
        }

        return response()->json(['error' => 'Có lỗi xảy ra']);
    }

    public function updateQuantityOrder(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'product' => 'required|string|max:5',
                'product_quantity' => 'required',
                'quantity' => 'required|integer|gt:0|max:' . $request->product_quantity,
                'feeShip' => 'required',
            ]
        );

        if ($validator->passes()) {
            $result = $this->orderRepo->updateCartAdmin($request->all());
            if ($result !== false) {
                $feeShip = $request->feeShip;
                return view('admin.order.table_product_create', ['carts' => $result, 'feeShip' => $feeShip]);
            } else {
                return response()->json(['error' => 'Có lỗi xảy ra']);
            }
        }

        return response()->json(['error' => 'Có lỗi xảy ra']);
    }
}
