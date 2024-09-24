<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issuance extends Model
{
    use HasFactory;

    protected $table = 'issuances';
    protected $primaryKey = 'issueID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'issuanceDate',
        'status'
    ];
}
