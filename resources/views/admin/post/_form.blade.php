<div class="d-flex justify-content-center">
    <div class="card col-md-10">
        <div class="card-header text-center">
            <h4>{{ $post->id ? 'Cập Nhật' : 'Thêm mới' }}</h4>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="category_id">Danh mục:</label><label style="color: red">(*)</label>
                <select class="form-control select2" id="category_id" name="category_id">
                    <option value="" selected>Chọn danh mục</option>
                    @foreach ($catePosts as $catePost)
                        <option value="{{ $catePost->id }}"
                            {{ old('category_id', $post->category_id) == $catePost->id ? 'selected' : '' }}>
                            {{ $catePost->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="name">Tên bài viết:</label><label style="color: red">(*)</label>
                <input type="text" class="form-control" value="{{ old('name', $post->name) }}" name="name"
                    autocomplete="off">
            </div>

            <div class="form-group">
                <label for="description">Nội dung bài viết:</label><label style="color: red">(*)</label>
                <textarea class="form-control" name="description" rows="3" autocomplete="off" id="description">{{ old('description', $post->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="author_name">Tên tác giả:</label><label style="color: red">(*)</label>
                <input type="text" class="form-control" value="{{ old('author_name', $post->author_name) }}"
                    name="author_name" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="image">Ảnh:</label>
                <input type="file" class="form-control img_preview" value="{{ old('image', $post->image) }}"
                    onchange="previewFile(this)" name="image">
                <div class="col-2 mt-1">
                    <img id="previewimg" class="border border-dark rounded-circle"
                        src="{{ $post->image ? asset('images/authors/' . $post->image) : asset('images/No_avatar.svg.png') }}"
                        alt="image" height="160" width="160">
                </div>
            </div>

            @if ($post->id)
                <div class="form-group">
                    <label for="catePosts">Trạng thái:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_active"
                            value='{{ config('consts.UNBLOCK') }}' @if ($post->is_active === config('consts.UNBLOCK')) checked @endif>
                        <label class="form-check-label">
                            Kích hoạt
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_active"
                            value='{{ config('consts.BLOCK') }}' @if ($post->is_active === config('consts.BLOCK')) checked @endif>
                        <label class="form-check-label">
                            Khóa
                        </label>
                    </div>
                </div>
            @endif

            <div class="box-footer text-center pb-2">
                <a href="{{ route('post.index') }}" class="btn btn-primary">Quay Lại</a>
                <button type="summit" class="btn btn-primary">{{ $post->id ? 'Cập Nhật' : 'Tạo Mới' }}</button>
            </div>
        </div>
    </div>

</div>

@push('js')
    <script src="{{ asset('js/preview_image.js') }}"></script>
    <script type="text/javascript" src="{{ asset('ckeditor_4.17.1_standard/ckeditor/ckeditor.js') }}"></script>
    <script>
        var options = {
            filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        };
        CKEDITOR.replace('description', options);
    </script>
@endpush
