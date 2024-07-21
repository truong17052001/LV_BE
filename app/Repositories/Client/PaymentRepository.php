<?php
namespace App\Repositories\Client;

use App\Models\Payment;
use App\Repositories\Base;

class PaymentRepository extends Base{
    
    protected $fieldSearchable = [
        'giatri',
        'trangthai',
        'pttt',
        'mabooking',
        'makh'
    ];

    public function getFieldSearchable(): array {
        return $this->fieldSearchable;

    }

    public function model(): string {
        return Payment::class;
    }
}