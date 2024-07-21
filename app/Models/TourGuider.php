<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourGuider extends Model
{
    public $table = 'tour_guider'; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ten',
        'sdt',
        'diachi',
        'email',
        'anh',
    ];
}
