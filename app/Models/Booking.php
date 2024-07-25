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
        'sobooking',
        'ngay',
        'trangthai',
        'ten',
        'sdt',
        'email',
        'diachi',
        'tongtien',
        'mand',
        'makh',
        'magg',
    ];
    public function detail(): HasMany
    {
        return $this->hasMany(DetailBooking::class, 'mabooking');
    }

    
}
