<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    public $table = 'hotel';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ten',
        'sdt',
        'diachi',
        'email',
        'website',
        'tieuchuan',
    ];
}
