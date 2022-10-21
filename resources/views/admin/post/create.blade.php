@extends('adminlte::page')

@section('title', 'Post')

@section('content_header')
    <h1>Quản lý bài viết</h1>
@stop

@section('content')
    <div class="container">
        @include('admin.layouts.alert')
        <form action="{{ route('post.store') }}" method="post" enctype='multipart/form-data'>
            @csrf
            @include('admin.post._form')
        </form>
    </div>
@stop

@push('js')
    {!! JsValidator::formRequest('App\Http\Requests\PostStoreRequest') !!}
@endpush
