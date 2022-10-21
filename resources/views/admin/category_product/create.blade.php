@extends('adminlte::page')

@section('title', 'Category Product')

@section('content_header')
    <h1>Quản lý danh mục sản phẩm</h1>
@stop

@section('content')
    <div class="container">
        @include('admin.layouts.alert')
        <form action="{{ route('category_product.store') }}" method="post">
            @csrf
            @include('admin.category_product._form')
        </form>
    </div>
@stop

@push('js')
    {!! JsValidator::formRequest('App\Http\Requests\CategoryProductStoreRequest') !!}
@endpush
