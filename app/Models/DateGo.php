<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DateGo extends Model
{
    public $table = 'date_go'; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'month',
        'seat',
        'id_tour',
        'id_guider',
    ];
}
