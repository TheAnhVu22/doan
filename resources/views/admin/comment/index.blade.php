@extends('adminlte::page')

@section('title', 'Comment')

@section('content_header')
    <h1>Bình luận sản phẩm</h1>
@stop

@section('content')
    <div class="container-fluid">
        @include('admin.layouts.alert')

        <div class="table-responsive">
            <table class="table table-bordered table-hover datatable">
                <thead class="thead-dark">
                    <tr class="header-table">
                        <th class="col-1">ID</th>
                        <th class="col-2">Tên sản phẩm</th>
                        <th class="col-1">Người bình luận</th>
                        <th class="col-3">Nội dung bình luận</th>
                        <th class="col-3">Nội dung trả lời</th>
                        <th class="col-2"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($comments as $comment)
                        <tr>
                            <td>{{ $comment->id }}</td>
                            <td><a
                                    href="{{ route('product_detail', ['slug' => $comment->product?->slug]) }}">{{ $comment->product?->name }}</a>
                            </td>
                            <td>{{ $comment->name }}
                                <br>
                                <small>({{ $comment->created_at }})</small>
                            </td>
                            <td>{{ $comment->content }}</td>
                            <td>
                                @foreach ($comments_response as $response)
                                    @if ($response->comment_parent_id === $comment->id)
                                        <p>{{ $response->content }}</p>
                                        <a href="{{ route('comment.edit', ['comment' => $response]) }}"
                                            class="btn btn-sm btn-primary m-1">Sửa</a>
                                        <button class="btn btn-sm btn-danger m-1 btnDelete" data-toggle="modal"
                                            data-target="#modalDelete"
                                            data-action="{{ route('comment.destroy', ['comment' => $response]) }}">
                                            Xóa
                                        </button>
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('comment.show', ['comment' => $comment]) }}"
                                        class="btn btn-sm btn-primary m-1">Phản hồi</a>
                                    <button class="btn btn-sm btn-danger m-1 btnDelete" data-toggle="modal"
                                        data-target="#modalDelete"
                                        data-action="{{ route('comment.destroy', ['comment' => $comment]) }}">
                                        Xóa bình luận
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
