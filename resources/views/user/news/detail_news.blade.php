@extends('user.commons.layout')

@section('title', 'ATVSHOP')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/news.css') }}">
    <link rel="stylesheet" href="{{ asset('css/carousel_custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
@endpush

@section('content')
    <div class="container mt-5">
        <h2 class="text-center">Nội dung bài viết</h2>
        <hr>
        <h3 class="text-center">
            {{ $news->name }}
        </h3>
        <div class="d-flex justify-content-center">
            <img class="img-responsive" src="{{ asset('images/authors/' . $news->image) }}" alt="image newss">
        </div>
        <div class="row my-3">
            <p class="mx-3"><i class="fa fa-user"></i> {{ $news->author_name }}</p>
            <p><i class="fa fa-calendar"></i> {{ $news->created_at }}</p>
            <p class="mx-3"><i class="fas fa-eye"></i> {{ $news->views }}</p>
        </div>
        <div id="content-news">
            <div class="card-body">
                {!! $news->description !!}
            </div>
        </div>

        <hr>
        <div class="row" id="relate-new">
            <h4>Bài viết liên quan</h4>
            @include('user.news.slide')
        </div>
    </div>
@stop


@push('js')
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/carousel.js') }}"></script>
@endpush
