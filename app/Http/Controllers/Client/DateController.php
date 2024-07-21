<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\Client\DateRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DateController extends Controller
{
    private DateRepository $dateRepository;

    public function __construct(DateRepository $dateRepo)
    {
        $this->dateRepository = $dateRepo;
    }

    public function index(Request $request)
    {
        $search = [];

        $date = $this->dateRepository->getAll(
            $search,
        );
        return $this->sendResponseApi([
            'code' => 200,
            'data' => $date,
        ]);
    }
    public function show(Request $request)
    {
        $date = $this->dateRepository->getDetail(
            $request->id,
        );
        return $this->sendResponseApi([
            'code' => 200,
            'data' => $date,
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
            'ngay' => $request->ngay,
            'thang' => $request->thang,
            'songaydi' => $request->songaydi,
            'chongoi' => $request->chongoi,
            'matour' => $request->matour,
            'mahdv' => $request->mahdv,
        ];

        $this->dateRepository->create(
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
            'ngay' => $request->ngay,
            'thang' => $request->thang,
            'songaydi' => $request->songaydi,
            'chongoi' => $request->chongoi,
            'matour' => $request->matour,
            'mahdv' => $request->mahdv,
        ];

        $this->dateRepository->update(
            $id,
            $input
        );

        return $this->sendResponseApi([
            'code' => 200,
        ]);
    }
    public function delete($id)
    {
        $this->dateRepository->delete(
            $id,
        );

        return $this->sendResponseApi([
            'code' => 200,
        ]);
    }
}