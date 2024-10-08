<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    use HasFactory;

    protected $table = 'productions';
    protected $primaryKey = 'productionID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'userID',
        'dateEncoded',
        'year',
        'month',
        'status',
        'remarks'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function productionDetails()
    {
        return $this->hasMany(ProductionDetail::class, 'productionID');
    }
}
