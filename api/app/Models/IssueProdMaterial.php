<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueProdMaterial extends Model
{
    use HasFactory;

    protected $table = 'issueProdMaterials';
    protected $primaryKey = 'issueProdMatsID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'issueID',
        'reqProdMatsID',
        'qty_requested'
    ];
}
