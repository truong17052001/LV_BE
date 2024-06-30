<?php
namespace App\Repositories\Client;

use App\Models\DateGo;
use App\Repositories\Base;

class DateRepository extends Base{
    
    protected $fieldSearchable = [
        'date',
        'month',
        'seat',
        'id_tour',
        'id_guider',
    ];

    public function getFieldSearchable(): array {
        return $this->fieldSearchable;

    }

    public function model(): string {
        return DateGo::class;
    }
}