<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issuance extends Model
{
    use HasFactory;

    protected $table = 'issuances';
    protected $primaryKey = 'issue_ID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'issuance_date',
        'status'
    ];
}
