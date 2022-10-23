@extends('adminlte::page')

@section('title', 'Tag')

@section('content_header')
    <h1>Quản lý tag sản phẩm</h1>
@stop

@section('content')
    <div class="container">
        @include('admin.layouts.alert')
        <form action="{{ route('tag.update', ['tag' => $tag]) }}" method="post">
            @csrf
            @method("PUT")
            @include('admin.tag._form')
        </form> 
    </div>
@stop

@push('js')
    {!! JsValidator::formRequest('App\Http\Requests\TagUpdateRequest') !!}
@endpush