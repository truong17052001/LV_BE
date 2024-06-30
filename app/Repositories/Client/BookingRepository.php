<?php
namespace App\Repositories\Client;

use App\Models\Booking;
use App\Repositories\Base;

class BookingRepository extends Base
{
    protected $fieldSearchable = [
        'id_booking',
        'time_booking',
        'status',
        'name',
        'phone',
        'email',
        'address',
        'total_price',
        'id_date',
        'id_customer',
        'id_discount',
    ];

    public function getFieldSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Booking::class;
    }

    public function getList(array $search = [], int $page = null, int $limit = null, array $columns = ['*'])
    {
        $query = $this->allQuery($search);

        return $query->select(['id', 'code', 'title_tour', 'meet_place', 'price', 'img_tour', 'note'])
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