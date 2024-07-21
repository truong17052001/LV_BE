<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\Client\BookingRepository;
use App\Repositories\Client\DetailBookingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    private BookingRepository $bookingRepository;
    private DetailBookingRepository $detailBookingRepository;


    public function __construct(BookingRepository $bookingRepo, DetailBookingRepository $detailBookingRepo)
    {
        $this->bookingRepository = $bookingRepo;
        $this->detailBookingRepository = $detailBookingRepo;
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

        ]);
        $date = date('ymdHis');
        if ($validator->fails()) {
            return $this->sendResponseApi([
                'code' => '400',
                'error' => $validator->errors()->all()
            ]);
        }

        $booking = [
            'sobooking' => $date,
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
        $booking = $this->bookingRepository->create(
            $booking
        );
        $detailList = $request->detailBooking;
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
                'mabooking' => $date,
            ];
            $this->detailBookingRepository->create(
                $detailBookings
            );
        }


        return $this->sendResponseApi([
            'code' => 200,
            'data' => $booking
        ]);
    }

    public function edit($id, Request $request)
    {
        $validator = Validator::make($request->all(), [

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
}