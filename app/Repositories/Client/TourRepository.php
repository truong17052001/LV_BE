<?php
namespace App\Repositories\Client;

use App\Models\Tour;
use App\Repositories\Base;

class TourRepository extends Base
{
    protected $fieldSearchable = [
        'matour',
        'tieude',
        'noikh',
        'gia_a',
        'anh',
        'trangthai',
    ];

    public function getFieldSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Tour::class;
    }

    public function getList(array $input, int $page = null, int $limit = null, array $columns = ['*'])
    {
        $query = $this->allQuery();

        if (!empty($input['tieude'])) {
            $query->where('tieude', 'like', '%' . $input['tieude'] . '%');
        }

        if (!empty($input['diemden'])) {
            $query->whereHas('place', function ($query) use ($input) {
                $query->where('madd', $input['diemden']);
            });
        }

        if (!empty($input['ngaydi'])) {
            $query->whereHas('dateGo', function ($query) use ($input) {
                $query->whereDate('ngay', $input['ngaydi']);
            });
        }

        if (!empty($input['songay'])) {
            $query->whereHas('dateGo', function ($query) use ($input) {
                $query->where('songaydi', $input['songay']);
            });
        }

        if (!empty($input['songuoi'])) {
            $query->whereHas('dateGo', function ($query) use ($input) {
                $query->where('chongoi', '>=', $input['songuoi']);
            });
        }

        if (!empty($input['giamin']) && !empty($input['giamax'])) {
            $query->where('gia_a', '>=', $input['giamin'])
                ->where('gia_a', '<=', $input['giamax']);
        } elseif (!empty($input['giamin'])) {
            $query->where('gia_a', '>=', $input['giamin']);
        } elseif (!empty($input['giamax'])) {
            $query->where('gia_a', '<=', $input['giamax']);
        }

        // $query->whereHas('dateGo', function ($query) use ($input) {
        //     $query->where('chongoi', '>=', 0);
        // });

        return $query->select(['id', 'matour', 'tieude', 'noikh', 'gia_a', 'gia_c', 'anh', 'trangthai'])
            ->orderBy('id', 'asc')->paginate($limit, $columns, 'page', $page);
    }

    public function getDetail(int $id)
    {
        $query = $this->model->newQuery()
            ->with('images', function ($query) {
                $query->select(['matour', 'nguon']);
            })
            ->with('dateGo', function ($query) {
                $query->select(['id', 'ngay', 'thang', 'songaydi', 'chongoi', 'matour', 'mahdv']);
            })
            ->with('tourGuide', function ($query) {
                $query->select(['ten', 'sdt', 'email', 'anh']);
            })
            ->with('activities', function ($query) {
                $query->select(['matour', 'stt', 'ngay', 'tieude', 'mota']);
            })
            ->with('hotel', function ($query) {
                $query->select(['matour', 'maks']);
            })
            ->with('vehicle', function ($query) {
                $query->select(['matour', 'mapt']);
            })
            ->with('place', function ($query) {
                $query->select(['matour', 'madd']);
            });
        return $query->find($id);
    }
}