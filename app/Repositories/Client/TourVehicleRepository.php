<?php
namespace App\Repositories\Client;

use App\Models\TourVehicle;
use App\Repositories\Base;

class TourVehicleRepository extends Base{
    
    protected $fieldSearchable = [
        'matour',
        'mapt',
    ];

    public function getFieldSearchable(): array {
        return $this->fieldSearchable;

    }

    public function model(): string {
        return TourVehicle::class;
    }
}