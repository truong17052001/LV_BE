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
        'ngay',
        'thang',
        'songaydi',
        'chongoi',
        'matour',
        'mahdv',
    ];

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class, 'matour');
    }

}
