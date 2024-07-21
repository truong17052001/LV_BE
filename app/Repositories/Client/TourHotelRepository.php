<?php
namespace App\Repositories\Client;

use App\Models\TourHotel;
use App\Repositories\Base;

class TourHotelRepository extends Base{
    
    protected $fieldSearchable = [
        'matour',
        'maks',
    ];

    public function getFieldSearchable(): array {
        return $this->fieldSearchable;

    }

    public function model(): string {
        return TourHotel::class;
    }
}