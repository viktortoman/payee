<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterestRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'effective_date',
        'rate',
    ];

    protected $casts = [
        'effective_date' => 'date',
        'rate' => 'float',
    ];
}
