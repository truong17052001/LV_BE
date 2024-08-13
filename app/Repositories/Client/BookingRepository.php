<?php
namespace App\Repositories\Client;

use App\Models\Booking;
use App\Repositories\Base;

class BookingRepository extends Base
{
    protected $fieldSearchable = [
        'sobooking',
        'ngay',
        'trangthai',
        'ten',
        'sdt',
        'email',
        'diachi',
        'tongtien',
        'mand',
        'makh',
        'magg',
    ];

    public function getFieldSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Booking::class;
    }

    public function getDetail(int $id)
    {
        $query = $this->model->newQuery()
            ->with([
                'detail' => function ($query) {
                    $query->select(
                        'id',
                        'ten',
                        'gioitinh',
                        'ngaysinh',
                        'loai',
                        'mabooking',
                    );
                }
            ])
            ->with([
                'detailPayment' => function ($query) {
                    $query->select(
                        '*',
                    );
                }
            ])
        ;

        return $query->find($id);
    }
}