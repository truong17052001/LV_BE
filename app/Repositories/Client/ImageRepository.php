<?php
namespace App\Repositories\Client;

use App\Models\Image;
use App\Repositories\Base;

class ImageRepository extends Base{
    
    protected $fieldSearchable = [
        'id_tour',
        'src',
    ];

    public function getFieldSearchable(): array {
        return $this->fieldSearchable;

    }

    public function model(): string {
        return Image::class;
    }
}