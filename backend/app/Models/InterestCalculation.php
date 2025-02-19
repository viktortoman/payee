<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterestCalculation extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date',
        'principal_amount',
        'calculated_interest'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'principal_amount' => 'float',
        'calculated_interest' => 'float',
    ];
}
