<div class="header_top">
    <div class="container">
        <div class="d-flex justify-content-around" id="header_top">
            <p href="#"><i class="fa fa-phone"></i><span class="text-nowrap"> 0374667xxx</span></p>
            <p href="#"><i class="fa fa-envelope"></i><span class="text-nowrap"> anhxx@gmail.com</span></p>
            <p href="#"><i class="fas fa-truck"></i><span class="text-nowrap"> Toàn quốc</span></p>
            <p href="#"><i class="far fa-calendar-alt"></i><span class="text-nowrap"> Thứ 2 - Thứ 7</span></p>
        </div>
    </div>
</div>
<div id="menu">
    <nav class="container navbar navbar-expand-sm navbar-light" id="navbar">
        <a href="{{ route('homepage') }}" class="navbar-brand">ATVSHOP</a>
        <button class="navbar-toggler navbar-brand" data-target=".my-nav" data-toggle="collapse" aria-controls="my-nav"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse my-nav">
            <ul class="navbar-nav nav-right">
                <li class="nav-item">
                    <form action="{{ route('search_product') }}" method="get">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Nhập từ khóa" name="keywords">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit"><i
                                        class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </li>
                <li class="nav-item d-flex align-items-center">
                    <a href="{{ route('cart.index') }}" class="mr-1s"><i class="fas fa-shopping-cart"></i> <span
                            class="text-nowrap">Giỏ hàng</span></a>
                </li>
                <li class="nav-item d-flex align-items-center">
                    @if (Auth::guard('user')->check())
                        <div class="dropdown">
                            <p class="dropdown-toggle mb-0" id="dropdownMenuButton" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="far fa-user-circle"></i>
                                {{ Auth::guard('user')->user()->name ?? Auth::guard('user')->user()->email }}
                            </p>
                            <div class="dropdown-menu" id="header_wrap" aria-labelledby="dropdownMenuButton">
                                <p class="text-center">{{ Auth::guard('user')->user()->phone }}</p>
                                <hr>
                                <a href="{{ route('manager_account', ['user' => Auth::guard('user')->user()]) }}"
                                    class="btn btn-secondary btn-sm w-100 mb-1">Quản lý tài khoản</a>
                                <form action="{{ route('user_logout') }}" method="POST">
                                    @csrf
                                    <button class="btn btn-secondary btn-sm w-100" type="submit">Đăng xuất</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('user_login') }}"><i class="far fa-user-circle"></i><span class="text-nowrap">
                                Đăng nhập</span></a>
                    @endif
                </li>
            </ul>
        </div>
    </nav>
    <nav class="container navbar navbar-expand-sm navbar-light" id="navbar">
        <div id="my-nav" class="collapse navbar-collapse my-nav">
            <ul class="navbar-nav mr-auto menu-product">
                <li class="nav-item">
                    <a href="{{ route('category_product', ['slug' => 'dien-thoai']) }}"
                        class="d-flex mb-1 d-flex align-items-center {{ Request::segment(2) == 'dien-thoai' ? 'active' : '' }}">
                        <span><i class="fas fa-mobile-alt"></i> <span class="text-nowrap">Điện thoại</span></span></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('category_product', ['slug' => 'may-tinh']) }}"
                        class="d-flex mb-1 align-items-center {{ Request::segment(2) == 'may-tinh' ? 'active' : '' }}">
                        <span><i class="fas fa-laptop"></i> <span class="text-nowrap">Máy tính</span></span></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('category_product', ['slug' => 'tai-nghe']) }}"
                        class="d-flex mb-1 align-items-center {{ Request::segment(2) == 'tai-nghe' ? 'active' : '' }}">
                        <span><i class="fas fa-headphones"></i> <span class="text-nowrap">Tai nghe</span></span></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('category_product', ['slug' => 'dong-ho']) }}"
                        class="d-flex mb-1 align-items-center {{ Request::segment(2) == 'dong-ho' ? 'active' : '' }}">
                        <span><i class="far fa-clock"></i> <span class="text-nowrap">Đồng hồ</span></span></a>
                </li>
                <li class="nav-item">
                    <div class="dropdown mb-1">
                        <p class="dropdown-toggle mb-0" id="dropdownMenuButton" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <span><i class="far fa-keyboard"></i> <span class="text-nowrap">Phụ kiện</span></span>
                        </p>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @foreach (\App\Models\Product::ACCESSORIES as $key => $accessory)
                                <a href="{{ route('category_product', ['slug' => \Str::slug($accessory)]) }}"
                                    class="d-flex justify-content-center {{ Request::segment(2) === \Str::slug($accessory) ? 'active' : '' }}">{{ $accessory }}</a>
                            @endforeach
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="{{ route('show_list_news') }}"
                        class="d-flex mb-1 align-items-center
                        @if (Request::segment(1) == 'category-news' || Request::segment(1) == 'news') active @endif">
                        <span><i class="fas fa-newspaper"></i> <span class="text-nowrap">Tin tức</span></span></a>
                </li>
            </ul>
        </div>
    </nav>
</div>
