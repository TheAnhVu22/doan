@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Thống kê</h1>
@stop

@push('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <style>
        a {
            color: black;
        }

        #dashboard_chart {
            width: 100%;
            height: 300px;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <input type="hidden" id="url_statistical" value="{{ route('statistical') }}">
        <div class="row">
            <h4>Doanh số bán hàng:</h4>
            <div class="form-group ml-sm-5">
                <select id="filter_chart" class="form-control" name="filter_chart">
                    <option value="7">Tuần qua</option>
                    <option value="30">Tháng qua</option>
                    <option value="365">Năm qua</option>
                </select>
            </div>
        </div>
        <small class="ml-2">Đơn vị: VNĐ</small>
        <div id="dashboard_chart"></div>
        <div class="card">
            <div class="card-body row">
                <div class="col-md-6">
                    <h5 class="card-title"><b>Sản phẩm xem nhiều:</b></h5>
                    <br>
                    <ol>
                        @foreach ($products_most_view as $product)
                            <li>
                                <a class="col-6 col-sm-4 col-lg-3 mt-3"
                                    href="{{ route('product_detail', ['slug' => $product->slug]) }}">
                                    {{ $product->name }}<span class="mx-1">-</span>
                                    <span class="text-success text-nowrap">(<i class="fas fa-eye"></i>
                                        {{ $product->views }})</span>
                                </a>
                            </li>
                        @endforeach
                    </ol>
                </div>
                <div class="col-md-6">
                    <h5 class="card-title"><b>Bài viết xem nhiều:</b></h5>
                    <br>
                    <ol>
                        @foreach ($posts_most_view as $post)
                            <li>
                                <a class="col-6 col-sm-4 col-lg-3 mt-3"
                                    href="{{ route('news_detail', ['slug' => $post->slug]) }}">
                                    {{ $post->name }}<span class="mx-1">-</span>
                                    <span class="text-info text-nowrap">
                                        (<i class="fas fa-user"></i> {{ $post->author_name }})
                                    </span><span class="mx-1">-</span>
                                    <span class="text-success text-nowrap">(<i class="fas fa-eye"></i> {{ $post->views }})</span>
                                </a>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><b>Sản phẩm đã bán hết/sắp hết:</b></h5>
                <br>
                <ol>
                    @foreach ($products_out_of_stock as $product)
                        <li>
                            <a class="col-6 col-sm-4 col-lg-3 mt-3"
                                href="{{ route('product.edit', ['product' => $product]) }}">
                                {{ $product->name }} - <span class="text-danger">Số lượng còn lại:
                                    {{ $product->quantity }}</span>
                            </a>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            function getDataChartDashboard(type) {
                const url = $('#url_statistical').val();
                $.ajax({
                    url: url,
                    method: 'POST',
                    dataType: 'JSON',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    data: {
                        type: type
                    },
                    success: function(data) {
                        chart.setData(data);
                    }
                });
            }

            getDataChartDashboard(7);

            $('#filter_chart').change(function() {
                const type = $(this).val();
                getDataChartDashboard(type);
            })

            var chart = new Morris.Bar({
                element: 'dashboard_chart',
                stacked: true,
                resize: true,
                barColors: ['green', '#0B88F1', 'red'],
                hideHover: false,
                xkey: 'date',
                ykeys: ['totalOrder', 'totalPrice', 'totalProduct'],
                labels: ['Số đơn hàng', 'Doanh số', 'Số lượng sản phẩm đã bán']
            });

        });
    </script>
@stop
