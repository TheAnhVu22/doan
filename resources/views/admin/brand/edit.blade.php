@extends('adminlte::page')

@section('title', 'Brand')

@section('content_header')
    <h1>Quản lý thương hiệu</h1>
@stop

@section('content')
    <div class="container">
        @include('admin.layouts.alert')
        <form action="{{ route('brand.update', ['brand' => $brand]) }}" method="post">
            @csrf
            @method("PUT")
            @include('admin.brand._form')
        </form> 
    </div>
@stop

@push('js')
    {!! JsValidator::formRequest('App\Http\Requests\BrandUpdateRequest') !!}
@endpush