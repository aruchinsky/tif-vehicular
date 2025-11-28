<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Novedad extends Model
{
    use HasFactory;

    protected $table = 'novedades';

    protected $fillable = [
        'vehiculo_id',
        'tipo_novedad',
        'aplica',
        'observaciones',
    ];

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'vehiculo_id');
    }
}
