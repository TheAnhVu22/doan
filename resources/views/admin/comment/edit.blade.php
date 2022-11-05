@extends('adminlte::page')

@section('title', 'Comment')

@section('content_header')
    <h1>Quản lý bình luận sản phẩm</h1>
@stop

@section('content')
    <div class="container">
        @include('admin.layouts.alert')
        <form action="{{ route('comment.update', ['comment' => $comment]) }}" method="post">
            @csrf
            @method('PUT')
            <div class="d-flex justify-content-center">
                <div class="card col-md-10">
                    <div class="card-header text-center">
                        <h4>Cập nhật phản hồi</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Tên nhân viên:</label><label style="color: red">(*)</label>
                            <input type="text" class="form-control" value="{{ old('name', $comment->name) }}"
                                name="name" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="content">Nội dung phản hồi:</label><label style="color: red">(*)</label>
                            <textarea class="form-control" name="content" rows="3" autocomplete="off">{{ old('content', $comment->content) }}</textarea>
                        </div>

                        <input type="hidden" name="comment_parent_id" value="{{ $comment->comment_parent_id }}">
                        <input type="hidden" name="product_id" value="{{ $comment->product_id }}">

                        <div class="box-footer text-center pb-2">
                            <a href="{{ route('comment.index') }}" class="btn btn-primary">Quay Lại</a>
                            <button type="summit" class="btn btn-primary">Cập Nhật</button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
@stop
