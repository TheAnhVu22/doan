<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Models\Order;
use App\Repositories\OrderRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected $orderRepo;

    public function __construct(
        OrderRepository $orderRepository
    ) {
        $this->orderRepo = $orderRepository;
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

    public function create()
    {
        $products = [];
        $order = $this->orderRepo->newInstance();
        return view('admin.order.create', compact('order', 'products'));
    }

    public function store(OrderStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->validated();
            $this->orderRepo->create($params);
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
        $products = [];
        return view('admin.order.edit', compact('order', 'products'));
    }

    public function update(OrderUpdateRequest $request, Order $order)
    {
        DB::beginTransaction();
        try {
            $params = $request->validated();
            $this->orderRepo->update($order, $params);
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
            if ($order->status === Order::STATUS_NEW) {
                $this->orderRepo->cancelOrder($order);
            } else {
                return back()->withErrors('Không thể hủy đơn đã được duyệt!');
            }
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage())->withInput();
        }

        return redirect()->route('order.index')->with('status', 'Hủy Đơn Đặt Hàng Thành Công');
    }

    public function confirmOrder(Request $request)
    {
        $order =  $this->orderRepo->search($request->order_code, 'order_code', ['orderDetails', 'shipping', 'orderDetails.product']);
        if(!$order || $order->status !== Order::STATUS_NEW){
            return back()->withErrors('Xác nhận đơn hàng thất bại');
        }
        $order->status = Order::STATUS_PROCESSING;
        $order->save();
        return redirect()->route('order.index')->with('status', 'Xác Nhận Đơn Đặt Hàng Thành Công');
    }
}
