<?php
namespace App\Repositories\Client;

use App\Models\Place;
use App\Repositories\Base;

class PlaceRepository extends Base{
    
    protected $fieldSearchable = [
        'name_place',
        'dec_place',
        'state',
    ];

    public function getFieldSearchable(): array {
        return $this->fieldSearchable;

    }

    public function model(): string {
        return Place::class;
    }
}