@extends('adminlte::page')

@section('title', 'Product')

@section('content_header')
    <h1>Quản lý sản phẩm</h1>
@stop

@section('content')
    <div class="container">
        @include('admin.layouts.alert')
        <form action="{{ route('product.store') }}" method="post" enctype='multipart/form-data'>
            @csrf
            @include('admin.product._form')
        </form>
    </div>
@stop

@push('js')
    {!! JsValidator::formRequest('App\Http\Requests\ProductStoreRequest') !!}
@endpush
