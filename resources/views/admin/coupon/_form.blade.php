<div class="d-flex justify-content-center">
    <div class="card col-md-10">
        <div class="card-header text-center">
            <h4>{{ $coupon->id ? 'Cập Nhật' : 'Thêm mới' }}</h4>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="name">Tên mã giảm giá:</label><label style="color: red">(*)</label>
                <input type="text" class="form-control" value="{{ old('name', $coupon->name) }}" name="name"
                    autocomplete="off">
            </div>

            <div class="form-group">
                <label for="code">Mã:</label><label style="color: red">(*)</label>
                <input type="text" class="form-control" name="code" autocomplete="off"
                    value="{{ old('code', $coupon->code) }}">
            </div>

            <div class="form-group">
                <label for="roles">Kiểu giảm giá:</label>
                <div class="form-check">
                    <input class="form-check-input typeDiscount" type="radio" name="type"
                        value='{{ App\Models\Coupon::DISCOUNT_BY_PERCENT }}'
                        @if ((old('type') ?? $coupon->type) === App\Models\Coupon::DISCOUNT_BY_PERCENT) checked @endif>
                    <label class="form-check-label">
                        {{ App\Models\Coupon::TYPE_DISCOUNT[App\Models\Coupon::DISCOUNT_BY_PERCENT] }}
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input typeDiscount" type="radio" name="type"
                        value='{{ App\Models\Coupon::CASH_DISCOUNT }}' @if ((old('type') ?? $coupon->type) === App\Models\Coupon::CASH_DISCOUNT) checked @endif>
                    <label class="form-check-label">
                        {{ App\Models\Coupon::TYPE_DISCOUNT[App\Models\Coupon::CASH_DISCOUNT] }}
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="value" id="valueCoupon">Giá trị giảm:</label><label style="color: red">(*)</label>
                <input type="number" id="value" class="form-control" name="value" autocomplete="off"
                    value="{{ old('value', $coupon->value) }}">
            </div>

            <div class="form-group">
                <label for="quantity">Số lượng mã:</label><label style="color: red">(*)</label>
                <input type="number" class="form-control" name="quantity" autocomplete="off"
                    value="{{ old('quantity', $coupon->quantity) }}">
            </div>

            <div class="form-group">
                <label for="start_date">Ngày bắt đầu:</label><label style="color: red">(*)</label>
                <input type="date" class="form-control" name="start_date" autocomplete="off"
                    value="{{ old('start_date', $coupon->start_date) }}" onkeypress="return false">
            </div>

            <div class="form-group">
                <label for="end_date">Ngày kết thúc:</label><label style="color: red">(*)</label>
                <input type="date" class="form-control" name="end_date" autocomplete="off"
                    value="{{ old('end_date', $coupon->end_date) }}" onkeypress="return false">
            </div>

            <div class="box-footer text-center pb-2">
                <a href="{{ route('coupon.index') }}" class="btn btn-primary">Quay Lại</a>
                <button type="summit" class="btn btn-primary">{{ $coupon->id ? 'Cập Nhật' : 'Tạo Mới' }}</button>
            </div>
        </div>
    </div>

</div>

@push('js')
    <script src="{{ asset('js/coupon.js') }}"></script>
@endpush
