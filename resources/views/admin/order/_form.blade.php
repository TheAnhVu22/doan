<div class="d-flex justify-content-center">
    <div class="card col-12">
        <div class="card-header text-center">
            <h4>{{ $order->id ? 'Cập Nhật đơn hàng' : 'Tạo đơn hàng mới' }}</h4>
            @if ($order->id)
                <h6><b>Mã đơn:</b> {{ $order->order_code }}</h6>
                <h6><b>Ngày đặt:</b> {{ $order->created_at }}</h6>
            @endif
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group col-11">
                        <label for="shipping_name">Tên khách hàng:</label><label style="color: red">(*)</label>
                        <input type="text" class="form-control"
                            value="{{ old('shipping_name', $order->shipping?->shipping_name) }}" name="shipping_name"
                            autocomplete="off">
                    </div>

                    <div class="form-group col-11">
                        <label for="shipping_phone">Số điện thoại:</label><label style="color: red">(*)</label>
                        <input type="text" class="form-control"
                            value="{{ old('shipping_phone', $order->shipping?->shipping_phone) }}" name="shipping_phone"
                            autocomplete="off">
                    </div>

                    <div class="form-group col-11">
                        <label for="note">Ghi chú:</label>
                        <textarea class="form-control" name="note" rows="2" autocomplete="off">{{ old('note', $order->shipping?->note) }}</textarea>
                    </div>
                </div>
                <div class="col-sm-6">
                    @if ($order->id)
                        <input type="hidden" name="feeShip" value="{{ $order->fee_ship }}">
                        <div class="form-group">
                            <label for="shipping_address">Địa chỉ:</label><label style="color: red">(*)</label>
                            <textarea class="form-control" name="shipping_address" rows="3" autocomplete="off">{{ old('shipping_address', $order->shipping?->shipping_address) }}</textarea>
                        </div>
                    @else
                        <input type="hidden" id="url_fee_ship" value="{{ route('apply_feeship_admin') }}">
                        @include('admin.layouts.select_city')

                        <div id="select_district">
                            @include('admin.layouts.select_district')
                        </div>

                        <div id="select_ward">
                            @include('admin.layouts.select_ward')
                        </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="form-group col-4 rounded border p-3">
                    <label for="roles">Phương thức thanh toán:</label>
                    @foreach (\App\Models\Order::PAYMENT_METHOD as $payment => $text)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method"
                                value='{{ $payment }}' @if ((old('payment_method') ?? $order->shipping?->payment_method) === $payment) checked @endif>
                            <label class="form-check-label">
                                {{ $text }}
                            </label>
                        </div>
                    @endforeach
                </div>

                @if ($order->id)
                    <div class="form-group border border-danger shadow p-3 rounded col-6 offset-2">
                        <label for="status">Trạng thái đơn hàng:</label><label style="color: red">(*)</label>
                        <select class="form-control" id="status" name="status">
                            @foreach (\App\Models\Order::STATUS_ORDER as $status => $text)
                                <option value="{{ $status }}"
                                    {{ old('status', $order->status) === $status ? 'selected' : '' }}>
                                    {{ $text }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>

            <div id="table_product">
                @if ($order->id)
                    @include('admin.order.table_product_edit')
                @else
                    <button type="button" class="btn btn-secondary mb-3" data-toggle="modal"
                        data-target=".bd-example-modal-lg">
                        Cập nhật sản phẩm
                    </button>
                    @include('admin.order.modal_product')
                    <div id="list_product">
                        @include('admin.order.table_product_create')
                    </div>
                @endif
            </div>

            <div class="box-footer text-center pb-2">
                <a href="{{ route('order.index') }}" class="btn btn-primary">Quay Lại</a>
                <button type="summit" class="btn btn-primary">{{ $order->id ? 'Cập Nhật' : 'Thêm đơn' }}</button>
            </div>
        </div>
    </div>
</div>
