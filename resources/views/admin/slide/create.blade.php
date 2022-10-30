@extends('adminlte::page')

@section('title', 'slide')

@section('content_header')
    <h1>Quản lý Slide</h1>
@stop

@section('content')
    <div class="container">
        @include('admin.layouts.alert')
        <form action="{{ route('slide.store') }}" method="post" enctype='multipart/form-data'>
            @csrf
            @include('admin.slide._form')
        </form>
    </div>
@stop

@push('js')
    {!! JsValidator::formRequest('App\Http\Requests\SlideStoreRequest') !!}
@endpush
