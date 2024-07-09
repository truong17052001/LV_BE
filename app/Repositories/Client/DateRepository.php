<?php
namespace App\Repositories\Client;

use App\Models\DateGo;
use App\Repositories\Base;

class DateRepository extends Base
{

    protected $fieldSearchable = [
        'date',
        'month',
        'day',
        'seat',
        'id_tour',
        'id_guider',
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
                    $query->select('id', 'title_tour', 'img_tour', 'price');
                }
            ])
            ->find($id);

        return $query;
    }
}