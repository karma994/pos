<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSale extends Model
{
    public $table = 'customersales';
    use HasFactory;
    protected $fillable = [
        'name',
        'phoneno',
        'productQuantity',
        'billno',
        'amount',
        'discount',
        'journalno',
        'cashier',
        'branch',
        'created_at'

    ];
}
