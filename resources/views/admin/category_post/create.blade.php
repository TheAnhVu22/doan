@extends('adminlte::page')

@section('title', 'Category Post')

@section('content_header')
    <h1>Quản lý danh mục bài viết</h1>
@stop

@section('content')
    <div class="container">
        @include('admin.layouts.alert')
        <form action="{{ route('category_post.store') }}" method="post">
            @csrf
            @include('admin.category_post._form')
        </form>
    </div>
@stop

@push('js')
    {!! JsValidator::formRequest('App\Http\Requests\CategoryPostStoreRequest') !!}
@endpush
