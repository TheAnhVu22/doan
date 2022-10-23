@extends('adminlte::page')

@section('title', 'Coupon')

@section('content_header')
    <h1>Quản lý mã giảm giá</h1>
@stop

@section('content')
    <div class="container-fluid">
        @include('admin.layouts.alert')

        <a href="{{ route('coupon.create') }}" class="btn btn-primary mb-2">Thêm mã giảm giá</a>
        <div class="table-responsive">
            <table class="table table-bordered table-hover datatable">
                <thead class="thead-dark">
                    <tr class="header-table">
                        <th>ID</th>
                        <th>Tên mã giảm giá</th>
                        <th>Mã</th>
                        <th>Kiểu giảm giá</th>
                        <th>Giá trị giảm</th>
                        <th>Số lượng mã</th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày kết thúc</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($coupons as $coupon)
                        <tr>
                            <td>{{ $coupon->id }}</td>
                            <td>{{ $coupon->name }}</td>
                            <td>{{ $coupon->code }}</td>
                            <td>{{ \App\Models\Coupon::TYPE_DISCOUNT[$coupon->type] }}</td>
                            <td>{{ $coupon->value }}</td>
                            <td>{{ $coupon->quantity }}</td>
                            <td>{{ $coupon->start_date }}</td>
                            <td>{{ $coupon->end_date }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('coupon.edit', ['coupon' => $coupon]) }}" class="btn btn-primary m-1">Sửa</a>
                                    <button class="btn btn-danger m-1 btnDelete" data-toggle="modal" data-target="#modalDelete"
                                        data-action="{{ route('coupon.destroy', ['coupon' => $coupon]) }}">
                                        Xóa
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <td class="border" colspan="9">Không có dữ liệu</td>
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
