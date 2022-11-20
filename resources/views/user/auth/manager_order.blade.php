@extends('user.commons.layout')

@section('title', 'ATVSHOP')

@push('css')
    <link rel="stylesheet" href="{{ asset('DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endpush

@section('content')
    <div class="container mt-5">
        <h3>Lịch sử đơn đặt hàng</h3>
        @include('admin.layouts.alert')
        <div class="table-responsive">
            <table class="table table-bordered table-hover datatable">
                <thead class="thead-dark">
                    <tr class="header-table">
                        <th>STT</th>
                        <th>Tổng tiền</th>
                        <th>Ngày đặt hàng</th>
                        <th>Thanh toán</th>
                        <th>Trạng thái</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        @php
                            $totalPrice = 0;
                        @endphp
                        @foreach ($order->orderDetails as $orderDetail)
                            @php
                                $totalPrice += $orderDetail->price * $orderDetail->sales_quantity;
                            @endphp
                        @endforeach
                        @php
                            $totalPrice -= $order->coupon_id ? ($order->coupon?->type == 1 ? $totalPrice * ($order->coupon?->value / 100) : $order->coupon?->value) : 0;
                        @endphp
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ number_format($totalPrice + $order->fee_ship, 0, ',', '.') }}đ</td>
                            <td>{{ $order->created_at }}</td>
                            <td>{{ $order->shipping?->payment_method === \App\Models\Order::PAYMENT_EWALLET ? 'Đã thanh toán bằng paypal' : 'Thanh toán khi nhận hàng' }}</td>
                            <td>{{ $order->getStatusOrder($order->status) }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('detail_order', ['order' => $order->order_code]) }}"
                                        class="btn btn-primary m-1">Xem chi tiết</a>
                                    @if ($order->status === \App\Models\Order::STATUS_NEW && $order->shipping?->payment_method === \App\Models\Order::PAYMENT_CASH)
                                        <button type="button" class="btn btn-danger m-1 btnCancelOrder"
                                            data-id={{ $order->order_code }} data-url={{ route('cancel_order') }}>
                                            Hủy đơn
                                        </button>
                                        <input type="hidden" id="user_id" value={{ \Auth::guard('user')->user()->id }}>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <td class="border text-center" colspan="6">Bạn chưa đặt hàng lần nào</td>
                    @endforelse
                </tbody>
            </table>
        </div>
        <a href="{{ route('manager_account', ['user' => $user]) }}" class="btn btn-primary">Quay Lại</a>
    </div>
@stop

@push('js')
    <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/datatable.js') }}"></script>
    <script src="{{ asset('js/manager_order_user.js') }}"></script>
@endpush
