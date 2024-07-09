<?php
namespace App\Repositories\Client;

use App\Models\DetailBooking;
use App\Repositories\Base;

class DetailBookingRepository extends Base
{
    protected $fieldSearchable = [
        'name',
        'gender',
        'birthday',
        'type',
        'id_booking',
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