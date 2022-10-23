<hr>
<div class="table-responsive">
    <table class="table table-bordered table-hover datatable">
        <thead class="thead-dark">
            <tr class="header-table">
                <th>#</th>
                <th>Tên ảnh</th>
                <th>Ảnh</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($images as $key => $image)
                <tr>
                    <td class="text-center col-1">{{ ++$key }}</td>
                    <td data-image_id="{{ $image->id }}" class="text-center edit_image_name col-2 break-word" contenteditable>
                        {{ $image->name }}
                    </td>
                    <td class="text-center"><img src="{{ asset('uploads/product_images/'. $image->image ) }}" class="border border-dark rounded-circle" width="100px" height="100px">
                        <input type="file" class="file_image" style="width:40%;" data-image_id="{{ $image->id }}" data-product_id="{{ $product_id }}"
                            id="file-{{ $image->id }}" name="file" accept="image/*">
                    </td>
                    <td class="text-center">
                        <button type="button" data-image_id="{{ $image->id }}"
                            class="btn btn-danger delete-image">Xóa</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Sản phẩm chưa có ảnh nào</td>
                </tr>
            @endforelse
            </body>
    </table>
</div>
