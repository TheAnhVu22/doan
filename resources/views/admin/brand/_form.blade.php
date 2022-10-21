<div class="d-flex justify-content-center">
    <div class="card col-md-10">
        <div class="card-header text-center">
            <h4>{{ $brand->id ? 'Cập Nhật' : 'Thêm mới' }}</h4>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="name">Tên thương hiệu:</label><label style="color: red">(*)</label>
                <input type="text" class="form-control" value="{{ old('name', $brand->name) }}" name="name"
                    autocomplete="off">
            </div>

            <div class="form-group">
                <label for="description">Thông tin chi tiết:</label><label style="color: red">(*)</label>
                <textarea class="form-control" name="description" rows="3" autocomplete="off">{{ old('description', $brand->description) }}</textarea>
            </div>

            @if ($brand->id)
                <div class="form-group">
                    <label for="roles">Trạng thái:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_active"
                            value='{{ config('consts.UNBLOCK') }}' @if ($brand->is_active === config('consts.UNBLOCK')) checked @endif>
                        <label class="form-check-label">
                            Kích hoạt
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_active"
                            value='{{ config('consts.BLOCK') }}' @if ($brand->is_active === config('consts.BLOCK')) checked @endif>
                        <label class="form-check-label">
                            Khóa
                        </label>
                    </div>
                </div>
            @endif

            <div class="box-footer text-center pb-2">
                <a href="{{ route('brand.index') }}" class="btn btn-primary">Quay Lại</a>
                <button type="summit" class="btn btn-primary">{{ $brand->id ? 'Cập Nhật' : 'Tạo Mới' }}</button>
            </div>
        </div>
    </div>

</div>
