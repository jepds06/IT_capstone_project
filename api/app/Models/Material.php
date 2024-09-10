<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $table = 'materials';
    protected $primaryKey = 'materialID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'description',
        'specification',
        'brand',
        'unitOfMeasure'
    ];
}
