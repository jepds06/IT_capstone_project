<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $table = 'quotations';
    protected $primaryKey = 'quoteID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable =[
        'quotationDate',
        'description',
        'validityDate',
        'remarks'
    ];
}
