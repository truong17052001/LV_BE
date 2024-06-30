<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    public $table = 'booking'; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
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
    public function detailBookings(): HasMany
    {
        return $this->hasMany(Image::class, 'id_tour');
    }
}
