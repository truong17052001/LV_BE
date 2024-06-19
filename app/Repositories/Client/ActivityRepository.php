<?php
namespace App\Repositories\Client;

use App\Models\Activity;
use App\Repositories\Base;

class ActivityRepository extends Base{
    
    protected $fieldSearchable = [
        'id_tour',
        'title',
        'day',
        'date',
        'description',
    ];

    public function getFieldSearchable(): array {
        return $this->fieldSearchable;

    }

    public function model(): string {
        return Activity::class;
    }
}