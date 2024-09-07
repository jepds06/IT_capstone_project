<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountType extends Model
{
    use HasFactory;

    protected $table = 'account_types';
    protected $primaryKey = 'acc_type_ID';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'account_type_name'
    ];

    public function accounts()
    {
        return $this->hasMany(Account::class, 'acc_type_ID');
    }
}
