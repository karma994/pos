<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'quantity',
        'category',
        'cost_price',
        'selling_price',
        'barcode',
        'branch',
        'unit_of_measurement',
    ];

}
