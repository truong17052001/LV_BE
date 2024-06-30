<?php
namespace App\Repositories\Client;

use App\Models\Vehicle;
use App\Repositories\Base;

class VehicleRepository extends Base{
    
    protected $fieldSearchable = [
        'name',
        'capacity',
    ];

    public function getFieldSearchable(): array {
        return $this->fieldSearchable;

    }

    public function model(): string {
        return Vehicle::class;
    }
}