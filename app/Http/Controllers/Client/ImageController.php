<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\Client\ImageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
    private ImageRepository $imageRepository;

    public function __construct(ImageRepository $tourRepo)
    {
        $this->imageRepository = $tourRepo;
    }

    public function index(Request $request)
    {
        $search = [];

        $image = $this->imageRepository->getAll(
            $search,

        );
        return $this->sendResponseApi([
            'code' => 200,
            'data' => $image,
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
            'src' => $request->src,
        ];

        $this->imageRepository->create(
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
            'src' => $request->src,
        ];

        $this->imageRepository->update(
            $id,
            $input
        );

        return $this->sendResponseApi([
            'code' => 200,
        ]);
    }
    public function delete($id)
    {
        $this->imageRepository->delete(
            $id,
        );

        return $this->sendResponseApi([
            'code' => 200,
        ]);
    }
}