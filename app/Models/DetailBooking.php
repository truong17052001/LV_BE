<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DetailBooking extends Model
{
    public $table = 'detail_booking'; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ten',
        'gioitinh',
        'ngaysinh',
        'loai',
        'mabooking',
    ];
}
