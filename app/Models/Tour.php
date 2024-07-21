<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Tour extends Model
{
    public $table = 'tour'; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'matour',
        'tieude',
        'noikh',
        'gia_a',
        'gia_c',
        'anh',
        'trangthai',
    ];

    public function hotel(): HasMany
    {
        return $this->hasMany(TourHotel::class, 'matour');
    }

    public function vehicle(): HasMany
    {
        return $this->hasMany(TourVehicle::class, 'matour');
    }

    public function place(): HasMany
    {
        return $this->hasMany(TourPlace::class, 'matour');
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class, 'matour');
    }

    public function dateGo(): HasMany
    {
        return $this->hasMany(DateGo::class, 'matour');
    }

    public function activities(): HasMany 
    {
        return $this->hasMany(Activity::class, 'matour');
    }

    public function tourGuide(): HasOneThrough
    {
        return $this->hasOneThrough(TourGuider::class, DateGo::class, 'matour', 'id', 'id', 'mahdv');
    }

}
