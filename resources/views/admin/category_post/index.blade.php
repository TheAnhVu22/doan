@extends('adminlte::page')

@section('title', 'Category Post')

@section('content_header')
    <h1>Quản lý danh mục bài viết</h1>
@stop

@section('content')
    <div class="container-fluid">
        @include('admin.layouts.alert')

        <a href="{{ route('category_post.create') }}" class="btn btn-primary mb-2">Thêm danh mục bài viết</a>
        <div class="table-responsive">
            <table class="table table-bordered table-hover datatable">
                <thead class="thead-dark">
                    <tr class="header-table">
                        <th>ID</th>
                        <th>Tên danh mục</th>
                        <th>Mô tả</th>
                        <th>Trạng thái</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categoryPosts as $categoryPost)
                        <tr>
                            <td>{{ $categoryPost->id }}</td>
                            <td>{{ $categoryPost->name }}</td>
                            <td>{{ $categoryPost->description }}</td>
                            <td>{{ $categoryPost->is_active === config('consts.BLOCK') ? 'Bị Khóa' : 'Kích Hoạt' }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('category_post.edit', ['categoryPost' => $categoryPost]) }}" class="btn btn-primary m-1">Sửa</a>
                                    <button class="btn btn-danger m-1 btnDelete" data-toggle="modal" data-target="#modalDelete"
                                        data-action="{{ route('category_post.destroy', ['categoryPost' => $categoryPost]) }}">
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
