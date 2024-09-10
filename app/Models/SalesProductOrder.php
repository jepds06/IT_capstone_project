<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesProductOrder extends Model
{
    use HasFactory;

    protected $table = 'salesProductOrders';
    protected $primaryKey = 'slsPrdOrdID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'salesID',
        'prodOrdID',
    ];
}
