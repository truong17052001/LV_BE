<?php
namespace App\Repositories\Client;

use App\Models\Place;
use App\Repositories\Base;

class PlaceRepository extends Base{
    
    protected $fieldSearchable = [
        'ten',
        'mota',
        'trangthai',
        'anh'
    ];

    public function getFieldSearchable(): array {
        return $this->fieldSearchable;

    }

    public function model(): string {
        return Place::class;
    }
}