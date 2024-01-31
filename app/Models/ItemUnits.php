<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemUnits extends Model
{
    use HasFactory;
    protected $fillable = [
        'unit_name',
        'description',

    ];
    public function items()
    {
        return $this->hasMany(Item::class, 'item_units_id');
    }
}
