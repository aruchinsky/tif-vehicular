<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Productividad extends Model
{
    use HasFactory;

    protected $table = 'productividad';

    protected $fillable = [
        'personal_control_id',
        'fecha',
        'total_conductor',
        'total_vehiculos',
        'total_acompanante',
    ];

    public function personalControl()
    {
        return $this->belongsTo(PersonalControl::class, 'personal_control_id');
    }
}
