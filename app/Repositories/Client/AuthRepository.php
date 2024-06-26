<?php
namespace App\Repositories\Client;

use App\Models\User;
use App\Repositories\Base;

class AuthRepository extends Base{
    
    protected $fieldSearchable = [
        'name',
        'email',
        'password',
    ];

    public function getFieldSearchable(): array {
        return $this->fieldSearchable;

    }

    public function model(): string {
        return User::class;
    }
}