@extends('adminlte::page')

@section('title', 'Order')

@section('content_header')
    <h1>Đơn hàng</h1>
@stop

@section('content')
    <div class="container-fluid">
        @include('admin.layouts.alert')

        <div class="d-flex justify-content-between mb-1">
            <div class="col-4">
                <a href="{{ route('order.create') }}" class="btn btn-primary mb-2">Thêm đơn hàng</a>
            </div>
            <form>
                <div class="row border bg-white p-3">
                    <div class="form-check mr-2">
                        <input id="isDeleted" class="form-check-input" {{ request()->get('isDeleted') ? 'checked' : '' }}
                            type="checkbox" name="isDeleted" value="true">
                        <label for="isDeleted" class="form-check-label">Đơn hàng đã hủy</label>
                    </div>
                    <button type="submit" class="btn btn-sm btn-secondary">Tìm kiếm</button>
                </div>
            </form>

        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover datatable">
                <thead class="thead-dark">
                    <tr class="header-table">
                        <th>ID</th>
                        <th>Mã đơn</th>
                        <th>Tên khách hàng</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th></th>
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
                            $totalPrice -= $order->coupon_id ? ($order->coupon->type == 1 ? $totalPrice * ($order->coupon->value / 100) : $order->coupon) : 0;
                        @endphp
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->order_code }}</td>
                            <td>{{ $order->shipping->shipping_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($order->create_dt)->format('Y/m/d h:i:s') }}</td>
                            <td>{{ number_format($totalPrice + $order->fee_ship, 0, ',', '.') }}đ</td>
                            <td>{{ $order->deleted_at ? 'Đã hủy' : $order->getStatusOrder($order->status) }}</td>
                            <td>
                                @if (!$order->deleted_at && $order->status === \App\Models\Order::STATUS_NEW)
                                    <form action="{{ route('order.confirm_order') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="order_code" value="{{ $order->order_code }}">
                                        <button type="submit" class="btn btn-sm btn-success">
                                            Xác nhận
                                        </button>
                                    </form>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('order.show', ['order' => $order]) }}"
                                        class="btn btn-secondary m-1">Xem
                                        chi tiết</a>
                                    @if (!request()->get('isDeleted'))
                                        @if ($order->status !== \App\Models\Order::STATUS_COMPLETED)
                                            <a href="{{ route('order.edit', ['order' => $order]) }}"
                                                class="btn btn-primary m-1">Cập
                                                nhật</a>
                                        @endif
                                        @if ($order->status === \App\Models\Order::STATUS_NEW)
                                            <button class="btn btn-danger m-1 btnDelete" data-toggle="modal"
                                                data-target="#modalDelete"
                                                data-action="{{ route('order.destroy', ['order' => $order]) }}">
                                                Hủy đơn
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <td class="border" colspan="7">Không có dữ liệu</td>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @include('admin.layouts.modalDelete')
@stop

@push('js')
    <script src="{{ asset('js/datatable.js') }}"></script>
@endpush
