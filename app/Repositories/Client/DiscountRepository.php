<?php
namespace App\Repositories\Client;

use App\Models\Discount;
use App\Repositories\Base;

class DiscountRepository extends Base
{
    protected $fieldSearchable = [
        'code',
        'percent',
        'expired_at',
    ];

    public function getFieldSearchable(): array
    {
        return $this->fieldSearchable;

    }

    public function model(): string
    {
        return Discount::class;
    }
}