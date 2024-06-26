<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    // public function tour(): BelongsTo
    // {
    //     return $this->belongTo(Tour::class);
    // }
    // public function guider(): BelongsTo
    // {
    //     return $this->belongTo(TourGuider::class);
    // }
}
