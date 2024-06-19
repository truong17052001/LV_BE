<?php
namespace App\Repositories\Client;

use App\Models\TourGuider;
use App\Repositories\Base;

class TourGuiderRepository extends Base{
    
    protected $fieldSearchable = [
        'name',
        'phone',
        'email',
        'img',
    ];

    public function getFieldSearchable(): array {
        return $this->fieldSearchable;

    }

    public function model(): string {
        return TourGuider::class;
    }
}