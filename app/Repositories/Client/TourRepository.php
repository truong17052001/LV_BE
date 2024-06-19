<?php
namespace App\Repositories\Client;

use App\Models\Tour;
use App\Repositories\Base;

class TourRepository extends Base
{
    protected $fieldSearchable = [
        'code',
        'title_tour',
        'meet_place',
        'meet_date',
        'price',
        'img_tour',
        'note',
    ];

    public function getFieldSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Tour::class;
    }

    public function getList(array $search = [], int $page = null, int $limit = null, array $columns = ['*'])
    {
        $query = $this->allQuery($search);

        return $query->select(['id', 'code', 'title_tour', 'meet_place', 'meet_date', 'price', 'img_tour', 'note'])
            ->orderBy('id', 'asc')->paginate($limit, $columns, 'page', $page);
    }

    public function getDetail(int $id)
    {
        $query = $this->model->newQuery()
            ->with('images', function ($query) {
                $query->select(['id_tour', 'src']);
            })
            ->with('dateGo', function ($query) {
                $query->select(['date', 'month', 'seat', 'id_tour', 'id_guider']);
            })
            ->with('tourGuide', function ($query) {
                $query->select(['name', 'phone', 'email', 'img']);
            })
            ->with('activities', function ($query) {
                $query->select(['id_tour', 'day', 'date', 'title', 'description']);
            });

        return $query->find($id);
    }
}