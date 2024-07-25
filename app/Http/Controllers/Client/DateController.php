<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\Client\DateRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

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

    public function export($id, Request $request)
    {
        $dateGo = $this->dateRepository->find($id);
        // Fetch all bookings for this date
        $bookings = $dateGo->bookings;

        $customers = $bookings->flatMap(function ($booking) {
            return $booking->detail;
        });
        
        // Apply filters
        if ($request->has('name')) {
            $customers = $customers->filter(function ($customer) use ($request) {
                return str_contains($customer->ten, $request->name);
            });
        }
        if ($request->has('gender')) {
            $customers = $customers->filter(function ($customer) use ($request) {
                return $customer->gioitinh === $request->gender;
            });
        }
        if ($request->has('birthdate')) {
            $customers = $customers->filter(function ($customer) use ($request) {
                return $customer->ngaysinh === $request->birthdate;
            });
        }
        
        $filename = 'customers.xlsx';
        $headers = ['ID', 'Name', 'Gender', 'Birthdate', 'Adult'];
        
        $excelData = $customers->map(function ($customer) {
            return [$customer->id, $customer->ten, $customer->gioitinh, $customer->ngaysinh,$customer->loai];
        })->toArray(); // Ensure data is converted to array

        return Excel::download(new class ($headers, $excelData) implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithHeadings {
            protected $headers;
            protected $data;

            public function __construct($headers, $data)
            {
                $this->headers = $headers;
                $this->data = $data;
            }

            public function array(): array
            {
                return $this->data;
            }

            public function headings(): array
            {
                return $this->headers;
            }
        }, $filename);
    }

}