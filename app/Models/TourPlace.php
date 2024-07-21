<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourPlace extends Model
{
    public $table = 'tour_place'; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'matour',
        'madd',
    ];
}
