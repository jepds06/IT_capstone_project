<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales';
    protected $primaryKey = 'sales_ID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'sales_date',
    ];
}
