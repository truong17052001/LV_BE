<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\Client\TourRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    private TourRepository $tourRepository;

    public function __construct(TourRepository $tourRepo)
    {
        $this->tourRepository = $tourRepo;
    }

    public function index(Request $request)
    {
        $params = [
            'page' => (int) $request->get('page', 1),
            'limit' => (int) $request->get('limit', 100),
        ];

        $search = [];

        $tours = $this->tourRepository->getList(
            $search,
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
            'code' => $request->code,
            'title_tour' => $request->title_tour,
            'meet_place' => $request->meet_place,
            'meet_date' => $request->meet_date,
            'price' => $request->price,
            'img_tour' => $request->img_tour,
            'note' => $request->note,
        ];

        $this->tourRepository->create(
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
            'code' => $request->code,
            'title_tour' => $request->title_tour,
            'meet_place' => $request->meet_place,
            'meet_date' => $request->meet_date,
            'price' => $request->price,
            'img_tour' => $request->img_tour,
            'note' => $request->note,
        ];

        $this->tourRepository->update(
            $id,
            $input
        );

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