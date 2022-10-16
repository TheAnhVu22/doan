@extends('adminlte::page')

@section('title', 'Admin')

@section('content_header')
    <h1>Quản lý nhân viên</h1>
@stop

@section('content')
    <div class="container-fluid">
        @include('admin.layouts.alert')

        <a href="{{ route('admin.create') }}" class="btn btn-primary mb-2">Thêm nhân viên</a>
        <div class="table-responsive">
            <table class="table table-bordered table-hover datatable">
                <thead class="thead-dark">
                    <tr class="header-table">
                        <th>ID</th>
                        <th>Tài khoản</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Ngày sinh</th>
                        <th>Vai trò</th>
                        <th>Trạng thái</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($admins as $admin)
                        <tr>
                            <td>{{ $admin->id }}</td>
                            <td>{{ $admin->username }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->phone }}</td>
                            <td>{{ $admin->birthday }}</td>
                            <td>{{ $admin->role?->name }}</td>
                            <td>{{ $admin->is_active === config('consts.BLOCK') ? 'Bị Khóa' : 'Kích Hoạt' }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('admin.edit', ['admin' => $admin]) }}" class="btn btn-primary m-1">Sửa</a>
                                    <button class="btn btn-danger m-1 btnDelete" data-toggle="modal" data-target="#modalDelete"
                                        data-action="{{ route('admin.destroy', ['admin' => $admin]) }}">
                                        Xóa
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <td class="border" colspan="8">Không có dữ liệu</td>
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
