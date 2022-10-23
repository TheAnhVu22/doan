@extends('adminlte::page')

@section('title', 'Comment')

@section('content_header')
    <h1>Bình luận sản phẩm</h1>
@stop

@section('content')
    <div class="container-fluid">
        @include('admin.layouts.alert')

        <a href="{{ route('comment.create') }}" class="btn btn-primary mb-2">Thêm bình luận</a>
        <div class="table-responsive">
            <table class="table table-bordered table-hover datatable">
                <thead class="thead-dark">
                    <tr class="header-table">
                        <th>ID</th>
                        <th>Tên sản phẩm</th>
                        <th>Người bình luận</th>
                        <th>Nội dung bình luận</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($comments as $comment)
                        <tr>
                            <td>{{ $comment->id }}</td>
                            <td>{{ $comment->product?->name }}</td>
                            <td>{{ $comment->name }}</td>
                            <td>{{ $comment->content }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('comment.edit', ['comment' => $comment]) }}" class="btn btn-primary m-1">Sửa</a>
                                    <button class="btn btn-danger m-1 btnDelete" data-toggle="modal" data-target="#modalDelete"
                                        data-action="{{ route('comment.destroy', ['comment' => $comment]) }}">
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
