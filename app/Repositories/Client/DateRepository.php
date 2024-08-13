<?php
namespace App\Repositories\Client;

use App\Models\DateGo;
use App\Repositories\Base;

class DateRepository extends Base
{

    protected $fieldSearchable = [
        'ngay',
        'thang',
        'songaydi',
        'chongoi',
        'matour',
        'mahdv',
    ];

    public function getFieldSearchable(): array
    {
        return $this->fieldSearchable;

    }

    public function model(): string
    {
        return DateGo::class;
    }

    public function getDetail(int $id)
    {
        $query = $this->model->newQuery()
            ->with([
                'tour' => function ($query) {
                    $query->select('id', 'tieude', 'anh', 'gia_a', 'gia_c', 'matour','noikh');
                }
            ])
            ->with([
                'guider' => function ($query) {
                    $query->select('*');
                }
            ])
            ->find($id);

        return $query;
    }
}