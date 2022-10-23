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
            @include('admin.comment._form')
        </form>
    </div>
@stop
{{-- 
@push('js')
    {!! JsValidator::formRequest('App\Http\Requests\CommentStoreRequest') !!}
@endpush --}}
