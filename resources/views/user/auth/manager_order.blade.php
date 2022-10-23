@extends('user.commons.layout')

@section('title', 'ATVSHOP')

@push('css')
    <link rel="stylesheet" href="{{ asset('DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endpush

@section('content')
    <div class="container mt-5">
        <h3>Lịch sử đơn đặt hàng</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-hover datatable">
                <thead class="thead-dark">
                    <tr class="header-table">
                        <th>STT</th>
                        <th>Mã đơn hàng</th>
                        <th>Tổng tiền</th>
                        <th>Ngày đặt hàng</th>
                        <th>Trạng thái</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->order_code }}</td>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->created_at }}</td>
                            <td>{{ $order->getStatusOrder($order->status) }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <a href="#" class="btn btn-primary m-1">Xem chi tiết</a>
                                    <button class="btn btn-danger m-1 btnDelete" data-toggle="modal"
                                        data-target="#modalDelete" data-action="#">
                                        Xóa
                                    </button>
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
@endpush
