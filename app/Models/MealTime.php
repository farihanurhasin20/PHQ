<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealTime extends Model
{
    use HasFactory;
    protected $table = 'meal_times';

    protected $fillable = [
        'start_time',
        'end_time',
    ];
}
