<?php
namespace App\Repositories\Client;

use App\Models\Hotel;
use App\Repositories\Base;

class HotelRepository extends Base
{

    protected $fieldSearchable = [
        'name',
        'phone',
        'address',
        'email',
        'website',
        'standard',
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