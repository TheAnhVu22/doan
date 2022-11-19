<footer class="text-center text-lg-start" id="footer">
    <section>
        <div class="container text-center text-md-start">
            <div class="row mt-5">
                <a id="button-scroll-top"></a>
                <div class="col-md-3 col-lg-4 col-xl-3 mx-auto my-4">
                    <h6 class="text-uppercase fw-bold mb-4">
                        Thông tin cửa hàng
                    </h6>
                    <p>
                        Cửa hàng ATV chuyên bán điện thoại, máy tính, đồ điện tử chính hãng
                        <br>
                        Xem chi tiết thông tin cửa hàng <a href="{{ route('contact') }}"><b class="text-nowrap">tại
                                đây</b></a>
                    </p>
                </div>

                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto my-4">
                    <h6 class="text-uppercase fw-bold mb-4">
                        Chính sách Mua hàng và Bảo hành
                    </h6>
                    @foreach (\App\Models\Post::POLICIES as $news => $slug)
                        <p>
                            <a href="{{ route('news_detail', ['slug' => $slug]) }}"
                                class="text-dark"><span class="text-nowrap">{{ $news }}</span>
                            </a>
                        </p>
                    @endforeach
                </div>

                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto my-4">
                    <h6 class="text-uppercase fw-bold mb-4">
                        Danh mục sản phẩm
                    </h6>
                    <p>
                        <a href="{{ route('category_product', ['slug' => 'dien-thoai']) }}" class="text-dark"><span
                                class="text-nowrap">Điện thoại</span>
                        </a>
                    </p>
                    <p>
                        <a href="{{ route('category_product', ['slug' => 'may-tinh']) }}" class="text-dark"><span
                                class="text-nowrap">Máy tính</span>
                        </a>
                    </p>
                    <p>
                        <a href="{{ route('category_product', ['slug' => 'tai-nghe']) }}" class="text-dark"><span
                                class="text-nowrap">Tai nghe</span>
                        </a>
                    </p>
                    <p>
                        <a href="{{ route('category_product', ['slug' => 'dong-ho']) }}" class="text-dark"><span
                                class="text-nowrap">Đồng hồ</span>
                        </a>
                    </p>
                </div>

                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 my-4">
                    <h6 class="text-uppercase fw-bold mb-4">Liên hệ</h6>
                    <p><i class="fas fa-home"></i> Mễ Trì, Hà Nội, Việt Nam</p>
                    <p><i class="fas fa-phone"></i> + 0374667xxx</p>
                    <p><i class="fa fa-envelope"></i> theanhvuxx@gmail.com</p>
                </div>

            </div>
        </div>
    </section>
</footer>
