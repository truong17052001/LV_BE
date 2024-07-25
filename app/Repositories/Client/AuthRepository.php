<?php
namespace App\Repositories\Client;

use App\Models\User;
use App\Repositories\Base;

class AuthRepository extends Base
{

    protected $fieldSearchable = [
        'ten',
        'email',
        'matkhau',
        'gioitinh',
        'dakichhoat',
        'sdt',
        'diachi',
        'anh',
        'ngaysinh'
    ];

    public function getFieldSearchable(): array
    {
        return $this->fieldSearchable;

    }

    public function model(): string
    {
        return User::class;
    }

    public function getOrdered(int $id)
    {
        $query = $this->model->newQuery()
            ->with([
                'bookings' => function ($query) {
                    $query->select(
                       "*"
                    );
                }
            ]);

        return $query->find($id);
    }
}