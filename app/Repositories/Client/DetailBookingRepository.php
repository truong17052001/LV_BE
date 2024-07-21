<?php
namespace App\Repositories\Client;

use App\Models\DetailBooking;
use App\Repositories\Base;

class DetailBookingRepository extends Base
{
    protected $fieldSearchable = [
        'ten',
        'gioitinh',
        'ngaysinh',
        'loai',
        'mabooking',
    ];

    public function getFieldSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return DetailBooking::class;
    }
}