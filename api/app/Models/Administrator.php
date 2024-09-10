<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
    use HasFactory;

    protected $table = 'administrators';
    protected $primaryKey = 'admin_ID';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'account_ID',
        'admin_first_name',
        'admin_last_name',
        'contact_num',
        'admin_address'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_ID');
    }
}
