<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationDetail extends Model
{
    use HasFactory;

    protected $table = 'quotationDetails';
    protected $primaryKey = 'qteDetailID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable =[
        'quoteID',
        'materialID',
        'quantity',
        'quotePrice'
    ];

    public $timestamps = false;

    public function quotation()
    {
        return $this->belongsTo(Quotation::class, 'quoteID');
    }
    
    public function material()
    {
        return $this->belongsTo(Material::class, 'materialID');
    }
}
