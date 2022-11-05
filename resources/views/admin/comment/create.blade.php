@extends('adminlte::page')

@section('title', 'Comment')

@section('content_header')
    <h1>Quản lý bình luận sản phẩm</h1>
@stop

@section('content')
    <div class="container">
        @include('admin.layouts.alert')
        <form action="{{ route('comment.store') }}" method="post">
            @csrf
            <div class="d-flex justify-content-center">
                <div class="card col-md-10">
                    <div class="card-header text-center">
                        <h4>Phản hồi bình luận khách hàng</h4>
                    </div>
                    <p><b>Sản phẩm:</b> {{ $comment->product?->name }}</p>
                    <p><b>Tên người bình luận:</b> {{ $comment->name }}</p>
                    <p><b>Nội dung bình luận:</b> {{ $comment->content }}</p>
                    <p><b>Ngày bình luận:</b> {{ $comment->created_at }}</p>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Tên nhân viên:</label><label style="color: red">(*)</label>
                            <input type="text" class="form-control"
                                value="{{ old('name', \Auth::guard('admin')->user()->username) }}" name="name"
                                autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="content">Nội dung phản hồi:</label><label style="color: red">(*)</label>
                            <textarea class="form-control" name="content" rows="3" autocomplete="off">{{ old('content') }}</textarea>
                        </div>

                        <input type="hidden" name="comment_parent_id" value="{{ $comment->id }}">
                        <input type="hidden" name="product_id" value="{{ $comment->product_id }}">

                        <div class="box-footer text-center pb-2">
                            <a href="{{ route('comment.index') }}" class="btn btn-primary">Quay Lại</a>
                            <button type="summit" class="btn btn-primary">Phản hồi</button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
@stop
