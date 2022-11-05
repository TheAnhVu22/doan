<div class="d-flex justify-content-center">
    <div class="card col-md-10">
        <div class="card-header text-center">
            <h4>{{ $product->id ? 'Cập Nhật' : 'Thêm mới' }}</h4>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="category_id">Danh mục:</label><label style="color: red">(*)</label>
                <select class="form-control select2" id="category_id" name="category_id">
                    <option value="" selected>Chọn danh mục</option>
                    @foreach ($cateProducts as $cateProduct)
                        <option value="{{ $cateProduct->id }}"
                            {{ old('category_id', $product->category_id) == $cateProduct->id ? 'selected' : '' }}>
                            {{ $cateProduct->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="brand_id">Thương hiệu:</label><label style="color: red">(*)</label>
                <select class="form-control select2" id="brand_id" name="brand_id">
                    <option value="" selected>Chọn thương hiệu</option>
                    @foreach ($brandProducts as $brandProduct)
                        <option value="{{ $brandProduct->id }}"
                            {{ old('brand_id', $product->brand_id) == $brandProduct->id ? 'selected' : '' }}>
                            {{ $brandProduct->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="name">Tên sản phẩm:</label><label style="color: red">(*)</label>
                <input type="text" class="form-control" value="{{ old('name', $product->name) }}" name="name"
                    autocomplete="off">
            </div>

            <div class="form-group">
                <label for="description">Nội dung sản phẩm:</label><label style="color: red">(*)</label>
                <textarea class="form-control" name="description" rows="3" autocomplete="off" id="description">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="price">Giá bán:</label><label style="color: red">(*)</label>
                <input type="number" class="form-control" value="{{ old('price', $product->price) }}" name="price"
                    autocomplete="off">
            </div>

            <div class="form-group">
                <label for="discount">Giảm giá (%):</label><label style="color: red">(*)</label>
                <input type="number" class="form-control" value="{{ old('discount', $product->discount) }}" name="discount"
                    autocomplete="off">
            </div>

            <div class="form-group">
                <label for="quantity">Số lượng:</label><label style="color: red">(*)</label>
                <input type="number" class="form-control" value="{{ old('quantity', $product->quantity) }}"
                    name="quantity" autocomplete="off">
            </div>

            <div class="form-group">  
                <label for="tag_id">Tag:</label><label style="color: red">(*)</label>
                <select class="form-control select2" id="tag_id" name="tag_id[]" multiple="multiple">
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}" {{ in_array($tag->id, $tagsId) ? 'selected' : '' }}>
                            {{ $tag->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            @if ($product->id)
                <div class="form-group">
                    <label for="cateproducts">Trạng thái:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_active"
                            value='{{ config('consts.UNBLOCK') }}' @if ($product->is_active === config('consts.UNBLOCK')) checked @endif>
                        <label class="form-check-label">
                            Kích hoạt
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_active"
                            value='{{ config('consts.BLOCK') }}' @if ($product->is_active === config('consts.BLOCK')) checked @endif>
                        <label class="form-check-label">
                            Khóa
                        </label>
                    </div>
                </div>
            @endif

            <div class="box-footer text-center pb-2">
                <a href="{{ route('product.index') }}" class="btn btn-primary">Quay Lại</a>
                <button type="summit" class="btn btn-primary">{{ $product->id ? 'Cập Nhật' : 'Tạo Mới' }}</button>
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
