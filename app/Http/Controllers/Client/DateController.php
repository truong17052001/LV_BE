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
        $id_temp = $this->dateRepository->find($id)->bookings;
        if (count($id_temp) <= 0) {
            $this->dateRepository->delete(
                $id,
            );
            return $this->sendResponseApi([
                'code' => 200,
            ]);
        } else {
            return $this->sendResponseApi([
                'code' => 400,
                'error' => ["Không thể xóa vì dữ liệu còn tồn tại ở bảng khác!"]
            ]);
        }
    }

    public function export($id, Request $request)
    {
        $dateGo = $this->dateRepository->find($id);
        $bookings = $dateGo->bookings;

        $customers = $bookings->flatMap(function ($booking) {
            return $booking->detail;
        });

        $filename = 'danhsach.xlsx';
        $headers = ['Mã', 'Họ tên', 'Giới tính', 'Ngày sinh', 'Độ tuổi'];

        $excelData = $customers->map(function ($customer) {
            return [
                $customer->id,
                $customer->ten,
                $customer->gioitinh,
                $customer->ngaysinh,
                $customer->loai == 1 ? 'Người lớn' : "Trẻ em"
            ];
        })->toArray();

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