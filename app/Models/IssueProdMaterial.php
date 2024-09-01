<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueProdMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'issue_ID',
        'req_prodmats_ID',
        'qty_requested'
    ];
}
