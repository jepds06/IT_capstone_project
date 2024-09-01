<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';
    protected $fillable = [
        'account_ID',
        'supplier_name',
        'supplier_address',
        'supplier_email',
        'supplier_contact_num',
        'supplier_type',
        'supplier_status'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_ID');
    }
}
