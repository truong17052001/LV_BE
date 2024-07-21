<?php
namespace App\Repositories\Client;

use App\Models\TourPlace;
use App\Repositories\Base;

class TourPlaceRepository extends Base{
    
    protected $fieldSearchable = [
        'matour',
        'madd',
    ];

    public function getFieldSearchable(): array {
        return $this->fieldSearchable;

    }

    public function model(): string {
        return TourPlace::class;
    }
}