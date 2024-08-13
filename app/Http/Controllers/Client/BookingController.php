<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\Client\BookingRepository;
use App\Repositories\Client\DetailBookingRepository;
use App\Repositories\Client\DateRepository;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Mail\ThankYouInvoiceMail;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    private BookingRepository $bookingRepository;
    private DetailBookingRepository $detailBookingRepository;
    private DateRepository $dateRepository;



    public function __construct(BookingRepository $bookingRepo, DetailBookingRepository $detailBookingRepo, DateRepository $dateRepo)
    {
        $this->bookingRepository = $bookingRepo;
        $this->detailBookingRepository = $detailBookingRepo;
        $this->dateRepository = $dateRepo;
    }

    public function index(Request $request)
    {
        $search = [];
        $bookings = $this->bookingRepository->getAll(
            $search,
        );
        return $this->sendResponseApi([
            'code' => 200,
            'data' => $bookings,
        ]);
    }

    public function detail($id)
    {
        $booking = $this->bookingRepository->getDetail($id);

        return $this->sendResponseApi([
            'code' => 200,
            'data' => $booking,
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'ngay' => 'required|date',
            'trangthai' => 'required|string',
            'ten' => 'required|string|max:255',
            'sdt' => 'required|digits:10|regex:/^[0-9]+$/',
            'diachi' => 'required|string|max:255',
            'mand' => 'required|integer',
            'makh' => 'required|integer',
            'magg' => 'nullable|integer',
            // 'detailBooking.adults' => 'required',
            // 'detailBooking.childrens' => 'required', 
            'detailBooking.adults.*.ten' => 'required|string|max:255',
            'detailBooking.adults.*.gioitinh' => 'required|string',
            'detailBooking.adults.*.ngaysinh' => 'required|date',
            'detailBooking.childrens.*.ten' => 'required|string|max:255',
            'detailBooking.childrens.*.gioitinh' => 'required|string',
            'detailBooking.childrens.*.ngaysinh' => 'required|date',
        ], [
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã được sử dụng.',
            'ngay.required' => 'Ngày là bắt buộc.',
            'ngay.date' => 'Ngày không hợp lệ.',
            'trangthai.required' => 'Trạng thái là bắt buộc.',
            'trangthai.string' => 'Trạng thái phải là chuỗi.',
            'ten.required' => 'Tên là bắt buộc.',
            'ten.string' => 'Tên phải là chuỗi.',
            'ten.max' => 'Tên không được vượt quá 255 ký tự.',
            'sdt.required' => 'Số điện thoại là bắt buộc.',
            'sdt.digits' => 'Số điện thoại phải có đúng 10 chữ số.',
            'sdt.regex' => 'Số điện thoại phải là số.',
            'diachi.required' => 'Địa chỉ là bắt buộc.',
            'diachi.string' => 'Địa chỉ phải là chuỗi.',
            'diachi.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            'mand.required' => 'Mã ngày đi là bắt buộc.',
            'mand.integer' => 'Mã ngày đi phải là số nguyên.',
            'makh.required' => 'Mã khách hàng là bắt buộc.',
            // 'detailBooking.adults.required' => 'Vui lòng nhập đầy đủ thông tin.',
            // 'detailBooking.childrens.required' => 'Vui lòng nhập đầy đủ thông tin.',
            'detailBooking.adults.*.ten.required' => 'Tên của người lớn là bắt buộc.',
            'detailBooking.adults.*.ten.string' => 'Tên của người lớn phải là chuỗi.',
            'detailBooking.adults.*.ten.max' => 'Tên của người lớn không được vượt quá 255 ký tự.',
            'detailBooking.adults.*.gioitinh.required' => 'Giới tính của người lớn là bắt buộc.',
            'detailBooking.adults.*.gioitinh.string' => 'Giới tính của người lớn phải là chuỗi.',
            'detailBooking.adults.*.ngaysinh.required' => 'Ngày sinh của người lớn là bắt buộc.',
            'detailBooking.adults.*.ngaysinh.date' => 'Ngày sinh của người lớn không hợp lệ.',
            'detailBooking.childrens.*.ten.required' => 'Tên của trẻ em là bắt buộc.',
            'detailBooking.childrens.*.ten.string' => 'Tên của trẻ em phải là chuỗi.',
            'detailBooking.childrens.*.ten.max' => 'Tên của trẻ em không được vượt quá 255 ký tự.',
            'detailBooking.childrens.*.gioitinh.required' => 'Giới tính của trẻ em là bắt buộc.',
            'detailBooking.childrens.*.gioitinh.string' => 'Giới tính của trẻ em phải là chuỗi.',
            'detailBooking.childrens.*.ngaysinh.required' => 'Ngày sinh của trẻ em là bắt buộc.',
            'detailBooking.childrens.*.ngaysinh.date' => 'Ngày sinh của trẻ em không hợp lệ.',
        ]);

        if ($validator->fails()) {
            return $this->sendResponseApi([
                'code' => '400',
                'error' => $validator->errors()->all()
            ]);
        }
        
        $date = $this->dateRepository->getDetail(
            $request->mand
        );

        $tongtien = $request->nguoilon * $date['tour']['gia_a'] + $request->treem * $date['tour']['gia_c'] - $request->giatrigiamgia;

        $date = date('ymdHis');

        $booking = [
            'sobooking' => $date,
            'ngay' => $request->ngay,
            'trangthai' => $request->trangthai,
            'ten' => $request->ten,
            'sdt' => $request->sdt,
            'email' => $request->email,
            'diachi' => $request->diachi,
            'tongtien' => $tongtien,
            'mand' => $request->mand,
            'makh' => $request->makh,
            'magg' => $request->magg,
        ];

        $booking = $this->bookingRepository->create(
            $booking
        );

        $this->sendThankYouEmail($booking);

        $date = $this->dateRepository->find(
            $request->mand,
        );

        $date['chongoi'] = $date['chongoi'] - $request->nguoilon - $request->treem;
        $input = ['chongoi' => $date->chongoi];

        $this->dateRepository->update(
            $request->mand,
            $input
        );
        $detailList = $request->detailBooking;
        if ($detailList != null) {
            foreach ($detailList['adults'] as $detail) {
                $detailBooking = [
                    'ten' => $detail['ten'],
                    'gioitinh' => $detail['gioitinh'],
                    'ngaysinh' => $detail['ngaysinh'],
                    'loai' => 1,
                    'mabooking' => $booking['id'],
                ];
                $this->detailBookingRepository->create(
                    $detailBooking
                );
            }

            foreach ($detailList['childrens'] as $detail) {
                $detailBookings = [
                    'ten' => $detail['ten'],
                    'gioitinh' => $detail['gioitinh'],
                    'ngaysinh' => $detail['ngaysinh'],
                    'loai' => 0,
                    'mabooking' => $booking['id'],
                ];
                $this->detailBookingRepository->create(
                    $detailBookings
                );
            }
        }else{
            return $this->sendResponseApi([
                'code' => '400',
                'error' => ["Vui lòng nhập đầy đủ thông tin"]
            ]);
        }

        return $this->sendResponseApi([
            'code' => 200,
            'data' => $booking
        ]);
    }

    public function edit($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'ngay' => 'required|date',
            'trangthai' => 'required|string',
            'ten' => 'required|string|max:255',
            'sdt' => 'required|digits:10|regex:/^[0-9]+$/',
            'diachi' => 'required|string|max:255',
            'tongtien' => 'required|numeric',
            'mand' => 'required|integer',
            'makh' => 'required|integer',
            'magg' => 'nullable|integer',
            'detailBooking.adults.*.ten' => 'required|string|max:255',
            'detailBooking.adults.*.gioitinh' => 'required|string',
            'detailBooking.adults.*.ngaysinh' => 'required|date',
            'detailBooking.childrens.*.ten' => 'required|string|max:255',
            'detailBooking.childrens.*.gioitinh' => 'required|string',
            'detailBooking.childrens.*.ngaysinh' => 'required|date',
        ], [
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã được sử dụng.',
            'ngay.required' => 'Ngày là bắt buộc.',
            'ngay.date' => 'Ngày không hợp lệ.',
            'trangthai.required' => 'Trạng thái là bắt buộc.',
            'trangthai.string' => 'Trạng thái phải là chuỗi.',
            'ten.required' => 'Tên là bắt buộc.',
            'ten.string' => 'Tên phải là chuỗi.',
            'ten.max' => 'Tên không được vượt quá 255 ký tự.',
            'sdt.required' => 'Số điện thoại là bắt buộc.',
            'sdt.digits' => 'Số điện thoại phải có đúng 10 chữ số.',
            'sdt.regex' => 'Số điện thoại phải là số.',
            'diachi.required' => 'Địa chỉ là bắt buộc.',
            'diachi.string' => 'Địa chỉ phải là chuỗi.',
            'diachi.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            'tongtien.required' => 'Tổng tiền là bắt buộc.',
            'tongtien.numeric' => 'Tổng tiền phải là số.',
            'mand.required' => 'Mã ngày đi là bắt buộc.',
            'mand.integer' => 'Mã ngày đi phải là số nguyên.',
            'makh.required' => 'Mã khách hàng là bắt buộc.',
            'detailBooking.adults.*.ten.required' => 'Tên của người lớn là bắt buộc.',
            'detailBooking.adults.*.ten.string' => 'Tên của người lớn phải là chuỗi.',
            'detailBooking.adults.*.ten.max' => 'Tên của người lớn không được vượt quá 255 ký tự.',
            'detailBooking.adults.*.gioitinh.required' => 'Giới tính của người lớn là bắt buộc.',
            'detailBooking.adults.*.gioitinh.string' => 'Giới tính của người lớn phải là chuỗi.',
            'detailBooking.adults.*.ngaysinh.required' => 'Ngày sinh của người lớn là bắt buộc.',
            'detailBooking.adults.*.ngaysinh.date' => 'Ngày sinh của người lớn không hợp lệ.',
            'detailBooking.childrens.*.ten.required' => 'Tên của trẻ em là bắt buộc.',
            'detailBooking.childrens.*.ten.string' => 'Tên của trẻ em phải là chuỗi.',
            'detailBooking.childrens.*.ten.max' => 'Tên của trẻ em không được vượt quá 255 ký tự.',
            'detailBooking.childrens.*.gioitinh.required' => 'Giới tính của trẻ em là bắt buộc.',
            'detailBooking.childrens.*.gioitinh.string' => 'Giới tính của trẻ em phải là chuỗi.',
            'detailBooking.childrens.*.ngaysinh.required' => 'Ngày sinh của trẻ em là bắt buộc.',
            'detailBooking.childrens.*.ngaysinh.date' => 'Ngày sinh của trẻ em không hợp lệ.',
        ]);

        if ($validator->fails()) {
            return $this->sendResponseApi([
                'code' => '400',
                'error' => $validator->errors()->all()
            ]);
        }

        $input = [
            'ngay' => $request->ngay,
            'trangthai' => $request->trangthai,
            'ten' => $request->ten,
            'sdt' => $request->sdt,
            'email' => $request->email,
            'diachi' => $request->diachi,
            'tongtien' => $request->tongtien,
            'mand' => $request->mand,
            'makh' => $request->makh,
            'magg' => $request->magg,
        ];

        $this->bookingRepository->update(
            $id,
            $input
        );

        return $this->sendResponseApi([
            'code' => 200,
        ]);
    }
    public function delete($id)
    {
        $this->bookingRepository->delete(
            $id,
        );

        return $this->sendResponseApi([
            'code' => 200,
        ]);
    }

    public function downloadPDF($id, Request $request)
    {
        $booking = $this->bookingRepository->getDetail(
            $id,
        );
        $date = $this->dateRepository->getDetail($booking->mand);
        $input = [
            'sobooking' => $booking->sobooking,
            'ten' => $booking->ten,
            'thanhtien' => $booking->tongtien,
            'ngay' => $booking->ngay,
            'detail' => $booking->detail,
            'payment' => $booking->detail_payment,
            'songaydi' => $date->songaydi,
            'ngaydi' => $date->ngay,
            'tieude' => $date->tour->tieude,
            'matour' => $date->tour->matour,
            'noikh' => $date->tour->noikh,
            'gianl' => $date->tour->gia_a,
            'giate' => $date->tour->gia_c,
            'tenhdv' => $date->guider->ten,
            'sdt' => $date->guider->sdt,
            'email' => $date->guider->email,

        ];

        $pdf = Pdf::loadView('invoice', ['details' => $input]);

        return $pdf->download('invoice.pdf');
    }

    public function sendThankYouEmail($request)
    {
        $details = [
            'ten' => $request->ten,
            'sobooking' => $request->sobooking,
            'tongtien' => $request->tongtien,
            'ngay' => $request->ngay
        ];
        Mail::to($request->email)->send(new ThankYouInvoiceMail($details));

        return response()->json(['message' => 'Email sent successfully']);
    }

}