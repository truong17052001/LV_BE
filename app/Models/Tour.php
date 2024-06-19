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
        'code',
        'title_tour',
        'meet_place',
        'meet_date',
        'price',
        'img_tour',
        'note',
    ];
    public function images(): HasMany
    {
        return $this->hasMany(Image::class, 'id_tour');
    }

    public function dateGo(): HasMany
    {
        return $this->hasMany(DateGo::class, 'id_tour');
    }

    public function tourGuide(): HasOneThrough
    {
        return $this->hasOneThrough(TourGuider::class, DateGo::class, 'id_tour', 'id', 'id', 'id_guider');
    }

    public function activities(): HasMany 
    {
        return $this->hasMany(Activity::class, 'id_tour');
    }
}
