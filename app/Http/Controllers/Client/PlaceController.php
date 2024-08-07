<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\Client\PlaceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlaceController extends Controller
{
    private PlaceRepository $placeRepository;

    public function __construct(PlaceRepository $placeRepo)
    {
        $this->placeRepository = $placeRepo;
    }

    public function index(Request $request)
    {
        $search = [];

        $places = $this->placeRepository->getAll(
            $search,

        );
        return $this->sendResponseApi([
            'code' => 200,
            'data' => $places,
        ]);
    }

    public function detail($id)
    {
        $place = $this->placeRepository->find($id);

        return $this->sendResponseApi([
            'code' => 200,
            'data' => $place,
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "ten" => "required",
            "mota" => "required",
            "trangthai" => "required",
            "anh" => "required",
        ], [
            'ten.required' => 'Tên địa danh là bắt buộc.',
            'mota.required' => 'Mô tả địa danh là bắt buộc.',
            'trangthai.required' => 'Trạng thái là bắt buộc.',
            'anh.required' => 'Ảnh là bắt buộc.',
        ]);

        if ($validator->fails()) {
            return $this->sendResponseApi([
                'code' => '400',
                'error' => $validator->errors()->all()
            ]);
        }

        $input = [
            'ten' => $request->ten,
            'mota' => $request->mota,
            'trangthai' => $request->trangthai,
            'anh' => $request->anh,
        ];

        $this->placeRepository->create(
            $input
        );

        return $this->sendResponseApi([
            'code' => 200,
        ]);
    }

    public function edit($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "ten" => "required",
            "mota" => "required",
            "trangthai" => "required",
            "anh" => "required",
        ], [
            'ten.required' => 'Tên địa danh là bắt buộc.',
            'mota.required' => 'Mô tả địa danh là bắt buộc.',
            'trangthai.required' => 'Trạng thái là bắt buộc.',
            'anh.required' => 'Ảnh là bắt buộc.',
        ]);

        if ($validator->fails()) {
            return $this->sendResponseApi([
                'code' => '400',
                'error' => $validator->errors()->all()
            ]);
        }

        $input = [
            'ten' => $request->ten,
            'mota' => $request->mota,
            'trangthai' => $request->trangthai,
            'anh' => $request->anh,
        ];

        $this->placeRepository->update(
            $id,
            $input
        );

        return $this->sendResponseApi([
            'code' => 200,
        ]);
    }
    public function delete($id)
    {
        $this->placeRepository->delete(
            $id,
        );

        return $this->sendResponseApi([
            'code' => 200,
        ]);
    }
}