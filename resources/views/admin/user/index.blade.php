@extends('adminlte::page')

@section('title', 'User')

@section('content_header')
    <h1>Quản lý khách hàng</h1>
@stop

@section('content')
    <div class="container-fluid">
        @include('admin.layouts.alert')

        <a href="{{ route('user.create') }}" class="btn btn-primary mb-2">Thêm khách hàng</a>
        <div class="table-responsive">
            <table class="table table-bordered table-hover datatable">
                <thead class="thead-dark">
                    <tr class="header-table">
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Kiểu đăng nhập</th>
                        <th>Trạng thái</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->provider_id ? 'Google' : '' }}</td>
                            <td>{{ $user->status === config('consts.BLOCK') ? 'Bị Khóa' : 'Kích Hoạt' }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('user.edit', ['user' => $user]) }}" class="btn btn-primary m-1">Sửa</a>
                                    <button class="btn btn-danger m-1 btnDelete" data-toggle="modal" data-target="#modalDelete"
                                        data-action="{{ route('user.destroy', ['user' => $user]) }}">
                                        Xóa
                                    </button>
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
