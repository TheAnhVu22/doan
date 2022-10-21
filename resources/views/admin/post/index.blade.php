@extends('adminlte::page')

@section('title', 'Post')

@section('content_header')
    <h1>Quản lý bài viết</h1>
@stop

@section('content')
    <div class="container-fluid">
        @include('admin.layouts.alert')

        <a href="{{ route('post.create') }}" class="btn btn-primary mb-2">Thêm bài viết</a>
        <div class="table-responsive">
            <table class="table table-bordered table-hover datatable">
                <thead class="thead-dark">
                    <tr class="header-table">
                        <th>ID</th>
                        <th>Bài viết</th>
                        <th>Danh mục</th>
                        <th>Tác giả</th>
                        <th>Lượt xem</th>
                        <th>Trạng thái</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>{{ $post->name }}</td>
                            <td>{{ $post->categoryPost?->name }}</td>
                            <td>{{ $post->author_name }}</td>
                            <td>{{ $post->view }}</td>
                            <td>{{ $post->is_active === config('consts.BLOCK') ? 'Bị Khóa' : 'Kích Hoạt' }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('post.edit', ['post' => $post]) }}" class="btn btn-primary m-1">Sửa</a>
                                    <button class="btn btn-danger m-1 btnDelete" data-toggle="modal" data-target="#modalDelete"
                                        data-action="{{ route('post.destroy', ['post' => $post]) }}">
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
