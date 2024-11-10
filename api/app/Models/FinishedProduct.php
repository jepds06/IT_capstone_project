<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinishedProduct extends Model
{
    use HasFactory;

    protected $table = 'finishedProducts';
    protected $primaryKey = 'fnshProductID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'prodtnDetailID',
        'productionDate',
        'quantity',
        'unitPrice',
        'status',
        'remarks'
    ];

    public function productionDetail()
    {
        return $this->belongsTo(ProductionDetail::class, 'prodtnDetailID');
    }
}
