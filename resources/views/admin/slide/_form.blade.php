<div class="d-flex justify-content-center">
    <div class="card col-md-10">
        <div class="card-header text-center">
            <h4>{{ $slide->id ? 'Cập Nhật' : 'Thêm mới' }}</h4>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="name">Tên:</label><label style="color: red">(*)</label>
                <input type="text" class="form-control" value="{{ old('name', $slide->name) }}" name="name"
                    autocomplete="off">
            </div>

            <div class="form-group">
                <label for="slide">Slide:</label>
                <input type="file" class="form-control img_preview" value="{{ old('slide', $slide->image) }}"
                    onchange="previewFile(this)" name="image">
                <div class="col-2 mt-1">
                    <img id="previewimg" class="border border-dark rounded-circle"
                        src="{{ $slide->image ? asset('images/slides/' . $slide->image) : asset('images/No_slide.png') }}"
                        alt="slide" height="160" width="160">
                </div>
            </div>

            <div class="box-footer text-center pb-2">
                <a href="{{ route('slide.index') }}" class="btn btn-primary">Quay Lại</a>
                <button type="summit" class="btn btn-primary">{{ $slide->id ? 'Cập Nhật' : 'Tạo Mới' }}</button>
            </div>
        </div>
    </div>

</div>

@push('js')
    <script src="{{ asset('js/preview_image.js') }}"></script>
@endpush
