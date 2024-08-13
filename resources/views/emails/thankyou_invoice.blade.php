<!-- resources/views/emails/thankyou_invoice.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Quang Trường Travel</title>
</head>

<body>
    <h1>Đây là hóa đơn thanh toán của bạn:</h1>

    <p>Mã booking của bạn: {{$details['sobooking']}}</p>
    <p>Tên của bạn: {{$details['ten']}}</p>
    <p>Ngày đặt tour: {{$details['ngay']}}</p>
    <p>Tổng giá trị đơn hàng của bạn: {{number_format($details['tongtien'], 0, ',', '.')}} VND</p>

    <h1>Cảm ơn bạn đã đặt tour tại website của chúng tôi</h1>
    <!-- Include details as needed -->
</body>

</html>