@extends('adminlte::page')

@section('title', 'Slide')

@section('content_header')
    <h1>Quản lý nhân viên</h1>
@stop

@section('content')
    <div class="container">
        @include('admin.layouts.alert')
        <form action="{{ route('slide.update', ['slide' => $slide]) }}" method="post" enctype='multipart/form-data'>
            @csrf
            @method("PUT")
            @include('admin.slide._form')
        </form> 
    </div>
@stop

@push('js')
    {!! JsValidator::formRequest('App\Http\Requests\SlideStoreRequest') !!}
@endpush