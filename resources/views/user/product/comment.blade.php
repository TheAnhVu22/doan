@foreach ($comments as $comment)
    <div class="row border border-secondary rounded mb-1">
        <div class="p-1">
            <p class="mb-0"><i class="fas fa-user"></i> <b>{{ $comment->name }}</b> - ({{ \Carbon\Carbon::parse($comment->created_at)->format('Y/m/d h:i:s') }})</p>
            <p class="mb-0 ml-2 text-break">{{ $comment->content }}</p>
        </div>
    </div>
    @foreach ($comments_response as $response)
        @if ($response->comment_parent_id === $comment->id)
            <div class="ml-3 row border border-primary rounded mb-2" style="background-color: aliceblue">
                <div class="p-1">
                    <p class="mb-0"><i class="fas fa-user-circle"></i> <b>{{ $response->name }}</b> - ({{ \Carbon\Carbon::parse($response->created_at)->format('Y/m/d h:i:s') }})
                        <span class="badge badge-warning">Quản trị viên</span>
                    </p>
                    <p class="ml-2">{{ $response->content }}</p>
                </div>
            </div>
        @endif
    @endforeach
@endforeach
