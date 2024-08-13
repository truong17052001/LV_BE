<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\Client\HotelRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HotelController extends Controller
{
    private HotelRepository $hotelRepository;

    public function __construct(HotelRepository $hotelRepo)
    {
        $this->hotelRepository = $hotelRepo;
    }

    public function index(Request $request)
    {
        $search = [];

        $hotels = $this->hotelRepository->getAll(
            $search,

        );
        return $this->sendResponseApi([
            'code' => 200,
            'data' => $hotels,
        ]);
    }

    public function detail($id)
    {
        $hotel = $this->hotelRepository->find($id);

        return $this->sendResponseApi([
            'code' => 200,
            'data' => $hotel,
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "email" => "required|email",
                "ten" => "required",
                "sdt" => "required",
                "diachi" => "required",
                "website" => "required",
                "tieuchuan" => "required",
            ],
            [
                'email.required' => 'Email là bắt buộc.',
                'email.email' => 'Email sai định dạng.',
                'ten.required' => 'Tên là bắt buộc.',
                'sdt.required' => 'Số điện thoại là bắt buộc.',
                'diachi.required' => 'Địa chỉ là bắt buộc.',
                'website.required' => 'Website là bắt buộc.',
                'tieuchuan.required' => 'Tiêu chuẩn là bắt buộc.',
            ]
        );

        if ($validator->fails()) {
            return $this->sendResponseApi([
                'code' => '400',
                'error' => $validator->errors()->all()
            ]);
        }

        $input = [
            'ten' => $request->ten,
            'sdt' => $request->sdt,
            'diachi' => $request->diachi,
            'email' => $request->email,
            'website' => $request->website,
            'tieuchuan' => $request->tieuchuan,

        ];

        $this->hotelRepository->create(
            $input
        );

        return $this->sendResponseApi([
            'code' => 200,
        ]);
    }

    public function edit($id, Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "email" => "required|email",
                "ten" => "required",
                "sdt" => "required",
                "diachi" => "required",
                "website" => "required",
                "tieuchuan" => "required",
            ],
            [
                'email.required' => 'Email là bắt buộc.',
                'email.email' => 'Email sai định dạng.',
                'ten.required' => 'Tên là bắt buộc.',
                'sdt.required' => 'Số điện thoại là bắt buộc.',
                'diachi.required' => 'Địa chỉ là bắt buộc.',
                'website.required' => 'Website là bắt buộc.',
                'tieuchuan.required' => 'Tiêu chuẩn là bắt buộc.',
            ]
        );

        if ($validator->fails()) {
            return $this->sendResponseApi([
                'code' => '400',
                'error' => $validator->errors()->all()
            ]);
        }

        $input = [
            'ten' => $request->ten,
            'sdt' => $request->sdt,
            'diachi' => $request->diachi,
            'email' => $request->email,
            'website' => $request->website,
            'tieuchuan' => $request->tieuchuan,
        ];

        $this->hotelRepository->update(
            $id,
            $input
        );

        return $this->sendResponseApi([
            'code' => 200,
        ]);
    }
    public function delete($id)
    {
        $this->hotelRepository->delete(
            $id,
        );

        return $this->sendResponseApi([
            'code' => 200,
        ]);
    }
}