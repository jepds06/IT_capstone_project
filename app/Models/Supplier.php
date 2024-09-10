<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';
    protected $primaryKey = 'supplierID';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'accountID',
        'supplierName',
        'supplierAddress',
        'supplierContactNum',
        'supplierType',
        'supplierStatus'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'accountID');
    }
}
