<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\Client\TourRepository;
use App\Repositories\Client\TourVehicleRepository;
use App\Repositories\Client\TourHotelRepository;
use App\Repositories\Client\TourPlaceRepository;
use App\Repositories\Client\ImageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TourController extends Controller
{
    private TourRepository $tourRepository;
    private TourVehicleRepository $tourVehicleRepository;
    private TourHotelRepository $tourHotelRepository;
    private TourPlaceRepository $tourPlaceRepository;
    private ImageRepository $imageRepository;

    public function __construct(TourRepository $tourRepo, TourVehicleRepository $vehicleRepo, TourHotelRepository $hotelRepo, TourPlaceRepository $placeRepo, ImageRepository $imageRepo)
    {
        $this->tourRepository = $tourRepo;
        $this->tourVehicleRepository = $vehicleRepo;
        $this->tourHotelRepository = $hotelRepo;
        $this->tourPlaceRepository = $placeRepo;
        $this->imageRepository = $imageRepo;
    }

    public function index(Request $request)
    {
        $params = [
            'page' => (int) $request->get('page', 1),
            'limit' => (int) $request->get('limit', 100),
        ];
        $input = [
            'tieude' => $request->get('tieude'),
            'diemden' => (int) $request->get('diemden'),
            'ngaydi' => $request->get('ngaydi'),
            'giamin' => (int)$request->get('giamin'),
            'giamax' => (int)$request->get('giamax'),
            'songuoi' => (int)$request->get('songuoi'),
            'songay' => (int)$request->get('songay'),
        ];
        $tours = $this->tourRepository->getList(
            $input,
            $params['page'],
            $params['limit'],
        );
        $params['total_page'] = $tours->total() ? $tours->lastPage() : 0;
        return $this->sendResponseApi([
            'code' => 200,
            'data' => $tours->items(),
            'paginate' => $params
        ]);
    }


    public function detail($id)
    {
        $tour = $this->tourRepository->getDetail($id);

        if (empty($tour)) {
            // return $this->sendError('Tour not found');
        }

        return $this->sendResponseApi([
            'code' => 200,
            'data' => $tour,
        ]);
    }

    public function create(Request $request)
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
            'matour' => $request->matour,
            'tieude' => $request->tieude,
            'noikh' => $request->noikh,
            'gia_a' => $request->gia_a,
            'gia_c' => $request->gia_c,
            'anh' => $request->anh,
            'trangthai' => $request->trangthai,
        ];

        $tour = $this->tourRepository->create(
            $input
        );

        foreach ($request['vehicles'] as $detail) {
            $vehicle = [
                'mapt' => $detail,
                'matour' => $tour->id,
            ];
            $this->tourVehicleRepository->create(
                $vehicle
            );
        }
        foreach ($request['hotels'] as $detail) {
            $hotel = [
                'maks' => $detail,
                'matour' => $tour->id,
            ];
            $this->tourHotelRepository->create(
                $hotel
            );
        }
        foreach ($request['places'] as $detail) {
            $place = [
                'madd' => $detail,
                'matour' => $tour->id,
            ];
            $this->tourPlaceRepository->create(
                $place
            );
        }
        foreach ($request['images'] as $detail) {
            $image = [
                'nguon' => $detail,
                'matour' => $tour->id,
            ];
            $this->imageRepository->create(
                $image
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
            'matour' => $request->matour,
            'tieude' => $request->tieude,
            'noikh' => $request->noikh,
            'gia_a' => $request->gia_a,
            'gia_c' => $request->gia_c,
            'anh' => $request->anh,
            'trangthai' => $request->trangthai,
        ];

        $tour = $this->tourRepository->update(
            $id,
            $input
        );
        $this->tourVehicleRepository->deleteByColumns(
            ['matour' => $tour->id]
        );
        foreach ($request['vehicle'] as $detail) {
            $vehicle = [
                'mapt' => $detail,
                'matour' => $tour->id,
            ];
            $this->tourVehicleRepository->create(
                $vehicle
            );
        }
        $this->tourHotelRepository->deleteByColumns(
            ['matour' => $tour->id]
        );
        foreach ($request['hotel'] as $detail) {
            $hotel = [
                'maks' => $detail,
                'matour' => $tour->id,
            ];
            
            $this->tourHotelRepository->create(
                $hotel
            );
        }
        $this->tourPlaceRepository->deleteByColumns(
            ['matour' => $tour->id]
        );
        foreach ($request['place'] as $detail) {
            $place = [
                'madd' => $detail,
                'matour' => $tour->id,
            ];
            $this->tourPlaceRepository->create(
                $place
            );
        }
        $this->imageRepository->deleteByColumns(
            ['matour' => $tour->id]
        );
        foreach ($request['images'] as $detail) {
            $image = [
                'nguon' => $detail,
                'matour' => $tour->id,
            ];
            $this->imageRepository->create(
                $image
            );
        }
        return $this->sendResponseApi([
            'code' => 200,
        ]);
    }
    public function delete($id)
    {
        $this->tourRepository->delete(
            $id,
        );

        return $this->sendResponseApi([
            'code' => 200,
        ]);
    }
}