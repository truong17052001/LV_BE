<?php
namespace App\Repositories\Client;

use App\Models\Booking;
use App\Repositories\Base;

class BookingRepository extends Base
{
    protected $fieldSearchable = [
        'id_booking',
        'time_booking',
        'status',
        'name',
        'phone',
        'email',
        'address',
        'total_price',
        'id_date',
        'id_customer',
        'id_discount',
    ];

    public function getFieldSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Booking::class;
    }

}