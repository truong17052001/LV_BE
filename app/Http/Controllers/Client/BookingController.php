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
        $booking = $this->bookingRepository->find($id);

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
            'id_booking' => $date,
            'time_booking' => $request->time_booking,
            'status' => $request->status,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'total_price' => $request->total_price,
            'id_date' => $request->id_date,
            'id_customer' => $request->id_customer,
            'id_discount' => $request->id_discount,
        ];
        $this->bookingRepository->create(
            $booking
        );
        $detailList = $request->detailBooking;
        foreach ($detailList['adults'] as $detail) {
            $detailBooking = [
                'name' => $detail['name'],
                'gender' => $detail['gender'],
                'birthday' => $detail['birthday'],
                'type' => 1,
                'id_booking' => $date,
            ];
            $this->detailBookingRepository->create(
                $detailBooking
            );
        }

        foreach ($detailList['childrens'] as $detail) {
            $detailBookings = [
                'name' => $detail['name'],
                'gender' => $detail['gender'],
                'birthday' => $detail['birthday'],
                'type' => 0,
                'id_booking' => $date,
            ];
            $this->detailBookingRepository->create(
                $detailBookings
            );
        }


        return $this->sendResponseApi([
            'code' => 200,
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
            'time_booking' => $request->time_booking,
            'status' => $request->status,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'total_price' => $request->total_price,
            'id_date' => $request->id_date,
            'id_customer' => $request->id_customer,
            'id_discount' => $request->id_discount,
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