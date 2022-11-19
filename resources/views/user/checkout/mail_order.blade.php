<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Xác nhận đơn đặt hàng ATVSHOP</title>
</head>

<body>
    <h2>Mail xác nhận đơn đặt hàng ATVSHOP</h2>
    <h6>Chào bạn {{ $data['email'] }},</h6>
    <h6>Cảm ơn bạn đã mua hàng tại cửa hàng chúng tôi, đơn hàng của bạn sẽ được xử lý sớm nhất có thể.</h6>
    <h6>Truy cập <a href="{{ $data['link'] }}">vào đây</a> để xem thông tin về đơn đặt hàng của bạn!</h6>
    <small>ATVSHOP</small>
</body>

</html>