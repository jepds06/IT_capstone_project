<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestProdMaterial extends Model
{
    use HasFactory;

    protected $table = 'requestProdMaterials';
    protected $primaryKey = 'reqProdMatsID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'prodtnMtrlID',
        'reqID',
        'qtyRequested'
    ];
}
