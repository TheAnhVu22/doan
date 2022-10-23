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
            @method("PUT")
            @include('admin.comment._form')
        </form> 
    </div>
@stop

{{-- @push('js')
    {!! JsValidator::formRequest('App\Http\Requests\commentUpdateRequest') !!}
@endpush --}}