<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\Client\VehicleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    private VehicleRepository $vehicleRepository;

    public function __construct(VehicleRepository $vehicleRepo)
    {
        $this->vehicleRepository = $vehicleRepo;
    }

    public function index(Request $request)
    {
        $search = [];

        $vehicles = $this->vehicleRepository->getAll(
            $search,

        );
        return $this->sendResponseApi([
            'code' => 200,
            'data' => $vehicles,
        ]);
    }

    public function detail($id)
    {
        $vehicle = $this->vehicleRepository->find($id);

        return $this->sendResponseApi([
            'code' => 200,
            'data' => $vehicle,
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
            'name' => $request->name,
            'capacity' => $request->capacity,
        ];

        $this->vehicleRepository->create(
            $input
        );

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
            'name' => $request->name,
            'capacity' => $request->capacity,
        ];

        $this->vehicleRepository->update(
            $id,
            $input
        );

        return $this->sendResponseApi([
            'code' => 200,
        ]);
    }
    public function delete($id)
    {
        $this->vehicleRepository->delete(
            $id,
        );

        return $this->sendResponseApi([
            'code' => 200,
        ]);
    }
}