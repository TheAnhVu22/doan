@extends('adminlte::page')

@section('title', 'Tag')

@section('content_header')
    <h1>Quản lý tag sản phẩm</h1>
@stop

@section('content')
    <div class="container">
        @include('admin.layouts.alert')
        <form action="{{ route('tag.store') }}" method="post">
            @csrf
            @include('admin.tag._form')
        </form>
    </div>
@stop

@push('js')
    {!! JsValidator::formRequest('App\Http\Requests\TagStoreRequest') !!}
@endpush
