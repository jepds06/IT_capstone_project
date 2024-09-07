<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';
    protected $primaryKey = 'customer_ID';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'account_ID',
        'cstr_first_name',
        'cstr_last_name',
        'contact_num',
        'cstr_address',
        'customer_type',
        'pref_contact_method',
        'cstr_status'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_ID');
    }
}
