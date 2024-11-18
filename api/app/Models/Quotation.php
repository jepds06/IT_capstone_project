<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $table = 'quotations';
    protected $primaryKey = 'quoteID';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable =[
        'quotationDate',
        'userID',
        'productionID',
        'remarks',
        'isCompleted'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function production()
    {
        return $this->belongsTo(Production::class, 'productionID');
    }

    public function quotationDetails()
    {
        return $this->hasMany(QuotationDetail::class, 'quoteID');
    }

    public function adminOrders()
    {
        return $this->hasOne(AdminOrder::class, 'quoteID');
    }
}
