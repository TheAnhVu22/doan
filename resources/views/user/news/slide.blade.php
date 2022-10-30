<div class="owl-carousel">
    @foreach ($relate_news as $item)
        <a href="{{ route('news_detail', ['slug' => $item->slug]) }}">
            <div class="card p-0">
                <img class="img-news card-img-top" src="{{ asset('images/authors/' . $item->image) }}" alt="image news">
                <div class="card-body d-flex flex-column">
                    <p class="card-title"><b>{{ $item->name }}</b></p>
                    <p class="card-text mt-auto">
                        <i class="fas fa-user-circle"></i> {{ $item->author_name }}
                        <br>
                        <small class="text-muted">
                            <i class="fas fa-clock"></i> {{ $item->created_at }}
                            - <span class="text-nowrap"><i class="fas fa-eye"></i> {{ $item->views }}</span>
                        </small>
                    </p>
                </div>
            </div>
        </a>
    @endforeach
</div>
