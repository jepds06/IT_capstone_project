<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueProdMaterial extends Model
{
    use HasFactory;

    protected $table = 'issue_prod_materials';
    protected $primaryKey = 'issue_prodmats_ID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'issue_ID',
        'req_prodmats_ID',
        'qty_requested'
    ];
}
