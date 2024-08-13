<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thank You for Your Purchase</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f9f9f9;
            color: #333;
            font-size: 13px;
        }

        h1 {
            color: #4CAF50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .header img {
            max-height: 50px;
            margin-right: 20px;
        }

        .label-cell {
            width: 30%;
        }

        .value-cell {
            width: 70%;
        }

        .header svg {
            width: 100px;
            height: auto;
            margin-bottom: 0;
        }

        .header svg path {
            fill: #4CAF50;
            stroke: #000000;
            stroke-width: 2;
        }
    </style>
</head>

<body>
    <div class="header">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="d-none d-xl-block"
            viewBox="0 0 55 53" width="55px" height="53px" style="margin-bottom: 0;">
            <path fill-rule="evenodd"
                d="M53.175,51.207 C50.755,53.610 46.848,53.595 44.448,51.172 L40.766,47.484 C40.378,47.082 40.378,46.443 40.766,46.041 C41.164,45.629 41.821,45.617 42.233,46.016 L45.915,49.702 C47.503,51.246 50.030,51.246 51.619,49.703 C53.243,48.125 53.283,45.529 51.708,43.902 L50.100,42.292 C49.712,41.889 49.712,41.251 50.100,40.849 C50.498,40.436 51.155,40.425 51.567,40.823 L53.174,42.433 C53.186,42.445 53.198,42.456 53.210,42.469 C55.610,44.892 55.594,48.804 53.175,51.207 ZM47.857,37.404 C47.757,37.404 47.657,37.389 47.561,37.360 C47.561,37.360 47.561,37.360 47.561,37.360 C47.012,37.196 46.700,36.617 46.864,36.068 C48.542,30.412 47.740,24.310 44.659,19.281 C38.665,9.497 25.886,6.432 16.116,12.434 C16.085,12.456 16.054,12.475 16.021,12.493 C15.518,12.767 14.888,12.581 14.614,12.078 C14.340,11.574 14.526,10.943 15.029,10.669 C18.623,8.455 22.761,7.284 26.981,7.287 C29.178,7.289 31.363,7.608 33.469,8.234 C45.556,11.831 52.442,24.559 48.851,36.662 C48.719,37.102 48.315,37.403 47.857,37.404 ZM13.802,8.022 L12.765,6.983 C12.377,6.581 12.377,5.943 12.765,5.540 C13.163,5.128 13.820,5.117 14.232,5.515 L15.269,6.553 C15.657,6.956 15.657,7.594 15.269,7.996 C14.871,8.409 14.214,8.420 13.802,8.022 ZM9.654,3.868 L9.084,3.297 C7.495,1.753 4.968,1.752 3.379,3.296 C1.755,4.874 1.715,7.470 3.291,9.096 L10.083,15.900 C10.278,16.094 10.387,16.358 10.387,16.634 C10.387,17.208 9.923,17.672 9.350,17.672 C9.075,17.672 8.812,17.563 8.617,17.368 L1.824,10.566 C1.812,10.554 1.800,10.542 1.788,10.530 C-0.611,8.107 -0.596,4.195 1.824,1.792 C4.243,-0.611 8.150,-0.596 10.550,1.827 L11.121,2.400 C11.129,2.408 11.138,2.416 11.146,2.425 C11.544,2.838 11.533,3.495 11.121,3.894 C10.709,4.292 10.052,4.280 9.654,3.868 ZM7.742,19.850 C8.260,20.096 8.480,20.715 8.234,21.233 C5.232,27.580 5.635,35.016 9.305,41.001 C15.302,50.780 28.080,53.839 37.845,47.834 C37.876,47.813 37.908,47.793 37.940,47.775 C38.444,47.501 39.073,47.687 39.347,48.191 C39.621,48.695 39.435,49.326 38.932,49.599 C35.338,51.814 31.200,52.984 26.981,52.981 C23.606,52.979 20.273,52.228 17.223,50.782 C5.829,45.380 0.966,31.751 6.360,20.342 C6.606,19.824 7.225,19.603 7.742,19.850 ZM40.262,35.347 C40.601,35.280 40.951,35.387 41.196,35.631 L43.270,37.708 C43.675,38.113 43.675,38.771 43.270,39.176 L39.551,42.900 C37.191,45.264 33.364,45.264 31.004,42.900 L24.906,36.795 L21.491,40.215 C21.086,40.620 20.430,40.620 20.025,40.215 L17.951,38.138 C17.719,37.905 17.612,37.576 17.660,37.251 L18.624,30.501 L12.590,24.460 C11.040,22.907 11.040,20.390 12.590,18.837 C14.141,17.285 16.654,17.285 18.205,18.837 L24.077,24.716 L35.851,18.820 C36.250,18.620 36.732,18.699 37.048,19.015 L39.122,21.092 C39.527,21.498 39.527,22.155 39.122,22.561 L30.521,31.173 L35.622,36.277 L40.262,35.347 ZM20.758,38.012 L23.440,35.327 L20.454,32.337 L19.784,37.036 L20.758,38.012 ZM34.541,38.138 L28.318,31.907 C27.914,31.501 27.914,30.844 28.318,30.439 L36.919,21.826 L36.107,21.013 L24.333,26.910 C23.934,27.109 23.452,27.031 23.136,26.715 L16.735,20.306 C16.379,19.949 15.897,19.749 15.394,19.750 C14.347,19.750 13.498,20.600 13.499,21.649 C13.496,22.153 13.695,22.638 14.051,22.995 L20.449,29.401 L25.635,34.593 L32.464,41.432 C34.014,42.984 36.528,42.984 38.078,41.432 L41.064,38.442 L40.115,37.492 L35.474,38.421 C35.135,38.488 34.786,38.382 34.541,38.138 Z">
            </path>
        </svg>
        <h1>Quang Trường Travel</h1>
    </div>
    <table>
        <thead>
            <tr>
                <th colspan="2">Thông tin khách hàng</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="label-cell">Khách hàng</td>
                <td class="value-cell">{{ $details['ten'] }}</td>
            </tr>
            <tr>
                <td class="label-cell">Ngày đặt</td>
                <td class="value-cell">{{ $details['ngay'] }}</td>
            </tr>
            <tr>
                <td class="label-cell">Mã booking</td>
                <td class="value-cell">{{ $details['sobooking'] }}</td>
            </tr>
            <!-- <tr>
                <td class="label-cell">Hình thức thanh toán</td>
                <td class="value-cell">Tiền mặt</td>
            </tr> -->
            <tr>
                <td class="label-cell">Tổng thành tiền</td>
                <td class="value-cell">{{ number_format($details['thanhtien'], 0, ',', '.') }} VND</td>
            </tr>
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <th colspan="5">Chi tiết đặt chỗ</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="label-cell">Tiêu đề tour</td>
                <td class="value-cell">{{ $details['tieude'] }}</td>
            </tr>
            <tr>
                <td class="label-cell">Mã tour</td>
                <td class="value-cell">{{ $details['matour'] }}</td>
            </tr>
            <tr>
                <td class="label-cell">Nơi khởi hành</td>
                <td class="value-cell">{{ $details['noikh'] }}</td>
            </tr>
            <tr>
                <td class="label-cell">Ngày khởi hành</td>
                <td class="value-cell">{{ $details['ngaydi'] }}</td>
            </tr>
            <tr>
                <td class="label-cell">Số ngày đi</td>
                <td class="value-cell">{{ $details['songaydi'] }}</td>
            </tr>
            <tr>
                <td class="label-cell">Giá người lớn</td>
                <td class="value-cell">{{ number_format($details['gianl'], 0, ',', '.') }} VND</td>
            </tr>
            <tr>
                <td class="label-cell">Giá trẻ em</td>
                <td class="value-cell">{{ number_format($details['giate'], 0, ',', '.') }} VND</td>
            </tr>
            <tr>
                <td class="label-cell">Tên hướng dẫn viên</td>
                <td class="value-cell">{{ $details['tenhdv'] }}</td>
            </tr>
            <tr>
                <td class="label-cell">Số điện thoại hướng dẫn viên</td>
                <td class="value-cell">{{ $details['sdt'] }}</td>
            </tr>
            <tr>
                <td class="label-cell">Số điện thoại hướng dẫn viên</td>
                <td class="value-cell">{{ $details['email'] }}</td>
            </tr>
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <th colspan="2">Danh sách hành khách</th>
            </tr>

        </thead>
        <tbody>
            <tr>
                <th colspan="2">Người lớn </th>
            </tr>
            @foreach ($details['detail'] as $detail)
                @if($detail['loai'] == 1)
                    <tr>
                        <td class="label-cell">Tên</td>
                        <td class="value-cell">{{ $detail['ten'] }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Giới tính</td>
                        <td class="value-cell">{{ $detail['gioitinh'] }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Ngày sinh</td>
                        <td class="value-cell">{{ $detail['ngaysinh'] }}</td>
                    </tr>
                @endif
            @endforeach
            <tr>
                <th colspan="2">Trẻ em</th>
            </tr>
            @foreach ($details['detail'] as $detail)
                @if($detail['loai'] == 0)
                    <tr>
                        <td class="label-cell">Tên</td>
                        <td class="value-cell">{{ $detail['ten'] }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Giới tính</td>
                        <td class="value-cell">{{ $detail['gioitinh'] }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Ngày sinh</td>
                        <td class="value-cell">{{ $detail['ngaysinh'] }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
    <h1>Cảm ơn, {{ $details['ten'] }}!</h1>
    <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p>
</body>

</html>