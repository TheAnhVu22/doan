@extends('user.commons.layout')

@section('title', 'ATVSHOP')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/carousel_custom.css') }}">
@endpush

@section('content')
    <div class="container mt-5">
        <h3 class="text-center">TIN TỨC</h3>
        <hr>
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <h5 class="text-center">Sắp xếp theo</h5>
                    <form method="get">
                        <div class="form-group">
                            <label for="category_slug">Danh mục:</label>
                            <select id="category_slug" class="form-control" name="category_slug">
                                <option value="">Tất cả</option>
                                @foreach ($categories_news as $category)
                                    <option value="{{ $category->slug }}"
                                        {{ $category->slug == request()->get('category_slug') ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="type_sort">Kiểu:</label>
                            <select id="type_sort" class="form-control" name="type_sort">
                                @foreach (config('consts.SORT_BY') as $key => $sort)
                                    <option value="{{ $key }}"
                                        {{ $key == request()->get('type_sort') ? 'selected' : '' }}>
                                        {{ $sort }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Từ khóa:</label>
                            <input type="text" name="keyword" id="keyword" class="form-control"
                                placeholder="Nhập từ khóa" autocomplete="off" value="{{ request()->get('keyword') }}">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Lọc</button>
                            <button type="button" id="resetBtn" class="btn btn-secondary">Xóa</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-9 pr-0 text-center">
                <div class="row d-flex justify-content-around">
                    @forelse ($news as $new)
                        <a class="card m-3 col-5 col-md-3 p-0" href="{{ route('news_detail', ['slug' => $new->slug]) }}">
                            <div class="img-hover-zoom">
                                <img height="100%" src="{{ asset('images/authors/' . $new->image) }}" alt="image news">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $new->name }}</h5>
                                <p class="card-text mt-auto">
                                    <i class="fas fa-user-circle"></i> {{ $new->author_name }}
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-clock"></i> {{ $new->created_at }}
                                        - <span class="text-nowrap"><i class="fas fa-eye"></i>
                                            {{ $new->views }}</span>
                                    </small>
                                </p>
                            </div>
                        </a>
                    @empty
                        <h5 class="text-center">Không có bài viết nào</h5>
                    @endforelse
                </div>

                <br>
                {{ $news->withQueryString()->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@stop

@push('js')
    <script>
        $(function() {
            $('#resetBtn').click(function() {
                $("select#category_slug").val("").change();
                $("select#type_sort").val("1").change();
                $("#keyword").val("");
            });
        })
    </script>
@endpush
