<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div style="position: sticky; top: 10px;">
                <div class="card bg-dark">
                    <div class="card-body">
                        <div class="input-group mb-3">
                            <input type="hidden" id="url_search" value="{{ route('admin_order_search_modal') }}">
                            <input type="search" id="keyword" class="form-control" placeholder="Tìm kiếm sản phẩm">
                            <div class="input-group-append">
                                <button class="btn btn-primary" id="btn_search" type="button">Tìm kiếm</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="all_product">
                @include('admin.order.table_all_product')
            </div>
        </div>
    </div>
</div>

