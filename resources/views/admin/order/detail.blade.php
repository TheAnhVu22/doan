@extends('adminlte::page')

@section('title', 'Order')

@section('content_header')
    <h1>Chi tiết đơn đặt hàng: Mã đơn ({{ $order->order_code }})</h1>
@stop

@section('content')
    <div class="container-fluid">
        <h6><b>Tên khách hàng: </b>{{ $order->shipping?->shipping_name }}</h6>
        <h6><b>Số điện thoại: </b>{{ $order->shipping?->shipping_phone }}</h6>
        <h6><b>Địa chỉ: </b>{{ $order->shipping?->shipping_address }}</h6>
        <h6><b>Phương thức thanh toán: </b>{{ $order->getPaymentMethod($order->shipping?->payment_method) }}</h6>
        <h6><b>Trạng thái đơn hàng: </b>{{ $order->getStatusOrder($order->status) }}</h6>
        <h6><b>Ghi chú: </b>{{ $order->shipping?->note }}</h6>
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr class="header-table">
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Ảnh</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalPrice = 0;
                @endphp
                @foreach ($order->orderDetails as $orderDetail)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>
                            {{ $orderDetail->product?->name }}
                        </td>
                        <td>
                            <img class="border border-dark rounded-circle"
                                src="{{ asset('uploads/product_images/' . optional($orderDetail->product?->productImages)[0]?->image) }}"
                                alt="orderDetail image" height="100" width="100">
                        </td>
                        <td>
                            {{ $orderDetail->sales_quantity }}
                        </td>
                        <td>{{ number_format($orderDetail->price, 0, ',', '.') }}</td>
                    </tr>
                    @php
                        $totalPrice += $orderDetail->price * $orderDetail->sales_quantity;
                    @endphp
                @endforeach
                <tr>
                    @php
                        $finalTotalPrice = $totalPrice + $order->fee_ship;
                    @endphp
                    <td colspan="5" class="text-right">
                        <p>Tạm tính: {{ number_format($totalPrice, 0, ',', '.') }} đ</p>
                        <p>Phí vận chuyển: {{ number_format($order->fee_ship, 0, ',', '.') }} đ</p>
                        @if ($order->coupon)
                            @php
                                $discount = $order->coupon?->type === 1 ? $totalPrice * ($order->coupon?->value / 100) : $totalPrice - $order->coupon?->value;
                                $finalTotalPrice -= $discount;
                            @endphp
                            <p>Số tiền giảm (mã giảm giá): {{ number_format($discount, 0, ',', '.') }} đ</p>
                        @endif
                        <p>
                            <b>
                                Tổng tiền: {{ number_format($finalTotalPrice, 0, ',', '.') }}</span> đ
                            </b>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
        <a href="{{ route('order.index') }}" class="btn btn-primary">Quay Lại</a>
    </div>
@stop
