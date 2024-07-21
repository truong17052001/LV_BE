<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourVehicle extends Model
{
    public $table = 'tour_vehicle'; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'matour',
        'mapt',
    ];
}
