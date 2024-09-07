<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $table = 'requests';
    protected $primaryKey = 'req_ID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'request_date',
        'status'
    ];
}