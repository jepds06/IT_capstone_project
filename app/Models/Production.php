<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    use HasFactory;

    protected $table = 'productions';
    protected $primaryKey = 'production_ID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'production_date',
        'est_production_days',
        'end_date',
        'quantity',
        'status'
    ];
}
