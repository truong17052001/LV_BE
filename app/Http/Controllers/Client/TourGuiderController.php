<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\Client\TourGuiderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TourGuiderController extends Controller
{
    private TourGuiderRepository $tourGuiderRepository;

    public function __construct(TourGuiderRepository $tourGuiderRepo)
    {
        $this->tourGuiderRepository = $tourGuiderRepo;
    }

    public function index(Request $request)
    {
        $search = [];

        $guider = $this->tourGuiderRepository->getAll(
            $search,
        );
        return $this->sendResponseApi([
            'code' => 200,
            'data' => $guider,
        ]);
    }
    public function detail(Request $request)
    {
        $guider = $this->tourGuiderRepository->find(
            $request->id,
        );
        return $this->sendResponseApi([
            'code' => 200,
            'data' => $guider,
        ]);
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|email",
            "ten" => "required",
            "sdt" => "required",
            "diachi" => "required",
            "anh" => "required",
        ], [
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'diachi.required' => 'Địa chỉ là bắt buộc',
            'sdt.required' => 'Số điện thoại là bắt buộc',
            'ten.required' => 'Tên là bắt buộc',
            'anh.required' => 'Ảnh là bắt buộc',
        ]);

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
            'anh' => $request->anh,
        ];

        $this->tourGuiderRepository->create(
            $input
        );

        return $this->sendResponseApi([
            'code' => 200,
        ]);
    }

    public function edit($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|email",
            "ten" => "required",
            "sdt" => "required",
            "diachi" => "required",
            "anh" => "required",
        ], [
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'diachi.required' => 'Địa chỉ là bắt buộc',
            'sdt.required' => 'Số điện thoại là bắt buộc',
            'ten.required' => 'Tên là bắt buộc',
            'anh.required' => 'Ảnh là bắt buộc',
        ]);

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
            'anh' => $request->anh,
        ];

        $this->tourGuiderRepository->update(
            $id,
            $input
        );

        return $this->sendResponseApi([
            'code' => 200,
        ]);
    }
    public function delete($id)
    {
        $this->tourGuiderRepository->delete(
            $id,
        );

        return $this->sendResponseApi([
            'code' => 200,
        ]);
    }
}