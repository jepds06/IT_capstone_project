<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierMaterialQuotation extends Model
{
    use HasFactory;

    protected $table = 'supplierMaterialQuotations';
    protected $primaryKey = 'suppMatsQuoteID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable =[
        'quoteID',
        'suppMatrlID',
        'quantity',
        'quotationPrice'
    ];
}
