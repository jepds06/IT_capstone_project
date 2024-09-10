<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionMaterial extends Model
{
    use HasFactory;

    protected $table = 'productionMaterials';
    protected $primaryKey = 'prodtnMtrlID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'productMatsID',
        'productionID'
    ];
}
