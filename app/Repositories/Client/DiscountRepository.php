<?php
namespace App\Repositories\Client;

use App\Models\Discount;
use App\Repositories\Base;

class DiscountRepository extends Base
{
    protected $fieldSearchable = [
        'magiamgia',
        'phantram',
        'hansd',
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