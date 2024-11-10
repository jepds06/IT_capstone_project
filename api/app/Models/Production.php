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
    public $timestamps = false;

    protected $fillable = [
        'userID',
        'dateEncoded',
        'startDate',
        'completionDate',
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

    public function quotations()
    {
        return $this->hasMany(Quotation::class, 'productionID');
    }
}
