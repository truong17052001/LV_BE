<?php
namespace App\Repositories\Client;

use App\Models\Token;
use App\Repositories\Base;

class TokenRepository extends Base{
    
    protected $fieldSearchable = [
        'user_id',
        'otp',
        'expired_at',
    ];

    public function getFieldSearchable(): array {
        return $this->fieldSearchable;

    }

    public function model(): string {
        return Token::class;
    }
}