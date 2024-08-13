<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\Client\DiscountRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiscountController extends Controller
{
    private DiscountRepository $discountRepository;

    public function __construct(DiscountRepository $discountRepo)
    {
        $this->discountRepository = $discountRepo;
    }

    public function index(Request $request)
    {

        $search = [];

        $discounts = $this->discountRepository->getAll(
            $search,

        );
        return $this->sendResponseApi([
            'code' => 200,
            'data' => $discounts,
        ]);
    }

    public function detail($id)
    {
        $discount = $this->discountRepository->find($id);

        return $this->sendResponseApi([
            'code' => 200,
            'data' => $discount,
        ]);
    }

    public function applyDiscount($ma)
    {
        $discount = $this->discountRepository->findByColumns(['magiamgia' => $ma]);

        return $this->sendResponseApi([
            'code' => 200,
            'data' => $discount,
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
            'magiamgia' => $request->magiamgia,
            'phantram' => $request->phantram,
            'hansd' => $request->hansd,
        ];

        $this->discountRepository->create(
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
            'magiamgia' => $request->magiamgia,
            'phantram' => $request->phantram,
            'hansd' => $request->hansd,
        ];

        $this->discountRepository->update(
            $id,
            $input
        );

        return $this->sendResponseApi([
            'code' => 200,
        ]);
    }
    public function delete($id)
    {
        $this->discountRepository->delete(
            $id,
        );

        return $this->sendResponseApi([
            'code' => 200,
        ]);
    }
}