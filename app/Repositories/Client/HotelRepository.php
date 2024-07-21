<?php
namespace App\Repositories\Client;

use App\Models\Hotel;
use App\Repositories\Base;

class HotelRepository extends Base
{

    protected $fieldSearchable = [
        'ten',
        'sdt',
        'diachi',
        'email',
        'website',
        'tieuchuan',
    ];

    public function getFieldSearchable(): array
    {
        return $this->fieldSearchable;

    }

    public function model(): string
    {
        return Hotel::class;
    }
}