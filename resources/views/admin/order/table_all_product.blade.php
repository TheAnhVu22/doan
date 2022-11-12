<div class="table-responsive">
    <table class="table table-bordered table-hover datatable">
        <thead class="thead-dark">
            <tr class="header-table">
                <th>ID</th>
                <th>Tên sản phẩm</th>
                <th>Thương hiệu</th>
                <th>Ảnh</th>
                <th>Giá bán</th>
                <th>Giảm giá</th>
                <th>Số lượng</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->brand?->name }}</td>
                    <td>
                        <img class="border border-dark rounded-circle"
                    src="{{ asset('uploads/product_images/' . optional($product->productImages)[0]?->image) }}"
                    alt="orderDetail image" height="80" width="80">
                    </td>
                    <td>{{ number_format($product->price, 0, ',', '.') }} đ</td>
                    <td>{{ $product->discount ?? 0 }}%</td>
                    <td>{{ $product->quantity }}</td>
                    <td>
                        <div class="d-flex justify-content-center">
                           <button type="button" data-product_id={{ $product->id }} class="btn btn-sm btn-success" id="btn_add_product">Thêm</button>
                        </div>
                    </td>
                </tr>
            @empty
                <td class="border" colspan="9">Không có dữ liệu</td>
            @endforelse
        </tbody>
    </table>
</div>