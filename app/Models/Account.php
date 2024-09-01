<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    
    protected $table = 'accounts';
    protected $fillable = [
        'username',
        'email',
        'password',
        'acc_type_ID'
    ];

    public function accountType()
    {
        return $this->belongsTo(AccountType::class, 'acc_type_ID');
    }
}
