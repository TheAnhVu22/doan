<div class="d-flex justify-content-center">
    <div class="card col-md-10">
        <div class="card-header text-center">
            <h4>{{ $categoryProduct->id ? 'Cập Nhật' : 'Thêm mới' }}</h4>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="name">Tên danh mục:</label><label style="color: red">(*)</label>
                <input type="text" class="form-control" value="{{ old('name', $categoryProduct->name) }}" name="name"
                    autocomplete="off">
            </div>

            <div class="form-group">
                <label for="image">Ảnh:</label>
                <input type="file" class="form-control img_preview"
                    value="{{ old('image', $categoryProduct->image) }}" onchange="previewFile(this)" name="image">
                <div class="col-2 mt-1">
                    <img id="previewimg" class="border border-dark rounded-circle"
                        src="{{ asset('images/categories_product/' . $categoryProduct->image) }}" alt="image"
                        height="160" width="160">
                </div>
            </div>

            <div class="form-group">
                <label for="description">Thông tin chi tiết:</label><label style="color: red">(*)</label>
                <textarea class="form-control" name="description" rows="3" autocomplete="off">{{ old('description', $categoryProduct->description) }}</textarea>
            </div>

            @if ($categoryProduct->id)
                <div class="form-group">
                    <label for="roles">Trạng thái:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_active"
                            value='{{ config('consts.UNBLOCK') }}' @if ($categoryProduct->is_active === config('consts.UNBLOCK')) checked @endif>
                        <label class="form-check-label">
                            Kích hoạt
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_active"
                            value='{{ config('consts.BLOCK') }}' @if ($categoryProduct->is_active === config('consts.BLOCK')) checked @endif>
                        <label class="form-check-label">
                            Khóa
                        </label>
                    </div>
                </div>
            @endif

            <div class="box-footer text-center pb-2">
                <a href="{{ route('category_product.index') }}" class="btn btn-primary">Quay Lại</a>
                <button type="summit"
                    class="btn btn-primary">{{ $categoryProduct->id ? 'Cập Nhật' : 'Tạo Mới' }}</button>
            </div>
        </div>
    </div>

</div>

@push('js')
    <script src="{{ asset('js/preview_image.js') }}"></script>
@endpush
