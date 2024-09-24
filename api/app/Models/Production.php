<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    use HasFactory;

    protected $table = 'productions';
    protected $primaryKey = 'productionID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'productionDate',
        'estProductionDays',
        'endDate',
        'quantity',
        'status'
    ];
}
