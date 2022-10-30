@extends('adminlte::page')

@section('title', 'Brand')

@section('content_header')
    <h1>Quản lý thương hiệu</h1>
@stop

@section('content')
    <div class="container-fluid">
        @include('admin.layouts.alert')

        <a href="{{ route('brand.create') }}" class="btn btn-primary mb-2">Thêm thương hiệu</a>
        <div class="table-responsive">
            <table class="table table-bordered table-hover datatable">
                <thead class="thead-dark">
                    <tr class="header-table">
                        <th>ID</th>
                        <th>Tên thương hiệu</th>
                        <th>Ảnh</th>
                        <th>Mô tả</th>
                        <th>Trạng thái</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($brands as $brand)
                        <tr>
                            <td>{{ $brand->id }}</td>
                            <td>{{ $brand->name }}</td>
                            <td>
                                <img id="previewimg" class="border border-dark rounded-circle"
                                src="{{ asset('images/brands/' . $brand->image) }}"
                                alt="slide" height="160" width="160">
                            </td>
                            <td>{{ $brand->description }}</td>
                            <td>{{ $brand->is_active === config('consts.BLOCK') ? 'Bị Khóa' : 'Kích Hoạt' }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('brand.edit', ['brand' => $brand]) }}" class="btn btn-primary m-1">Sửa</a>
                                    <button class="btn btn-danger m-1 btnDelete" data-toggle="modal" data-target="#modalDelete"
                                        data-action="{{ route('brand.destroy', ['brand' => $brand]) }}">
                                        Xóa
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <td class="border" colspan="5">Không có dữ liệu</td>
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
