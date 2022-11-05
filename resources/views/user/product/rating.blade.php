<ul class="list-inline row">
    @for ($count = 1; $count <= 5; $count++)
        @php
            if ($count <= $rating) {
                $color = 'color:#ffcc00;';
            } else {
                $color = 'color:#ccc;';
            }
        @endphp
        <li style="{{ $color }} font-size: 20px;">&#9733;</li>
    @endfor
    <p class="d-flex align-items-center mb-0 ml-1"> ({{ $rating1 }})</p>
</ul>