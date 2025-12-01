<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Productividad extends Model
{
    use HasFactory;

    protected $table = 'productividad';

    protected $fillable = [
        'control_personal_id',
        'fecha',
        'total_conductor',
        'total_vehiculos',
        'total_acompanante',
    ];

    public function controlPersonal()
    {
        return $this->belongsTo(ControlPersonal::class, 'control_personal_id');
    }
}
