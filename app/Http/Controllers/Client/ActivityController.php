<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\Client\ActivityRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ActivityController extends Controller
{
    private ActivityRepository $activityRepository;

    public function __construct(ActivityRepository $activityRepo)
    {
        $this->activityRepository = $activityRepo;
    }

    public function index(Request $request)
    {
        $search = [];

        $tours = $this->activityRepository->getAll(
            $search,
        );
        return $this->sendResponseApi([
            'code' => 200,
            'data' => $tours,
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
            'id_tour' => $request->id_tour,
            'title' => $request->title,
            'day' => $request->day,
            'date' => $request->date,
            'description' => $request->description,
        ];

        $this->activityRepository->create(
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
            'id_tour' => $request->id_tour,
            'title' => $request->title,
            'day' => $request->day,
            'date' => $request->date,
            'description' => $request->description,
        ];

        $this->activityRepository->update(
            $id,
            $input
        );

        return $this->sendResponseApi([
            'code' => 200,
        ]);
    }
    public function delete($id)
    {
        $this->activityRepository->delete(
            $id,
        );

        return $this->sendResponseApi([
            'code' => 200,
        ]);
    }
}