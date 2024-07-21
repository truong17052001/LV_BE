<?php
namespace App\Repositories\Client;

use App\Models\TourGuider;
use App\Repositories\Base;

class TourGuiderRepository extends Base{
    
    protected $fieldSearchable = [
        'ten',
        'sdt',
        'diachi',
        'email',
        'anh',
    ];

    public function getFieldSearchable(): array {
        return $this->fieldSearchable;

    }

    public function model(): string {
        return TourGuider::class;
    }
}