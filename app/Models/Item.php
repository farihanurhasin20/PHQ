<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    public function unit()
    {
        return $this->belongsTo(ItemUnits::class, 'item_units_id');
    }
}
