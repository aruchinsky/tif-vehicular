<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Conductor extends Model
{
    use HasFactory;

    protected $table = 'conductor';

    protected $fillable = [
        'dni_conductor',
        'nombre_apellido',
        'domicilio',
        'categoria_carnet',
        'tipo_conductor',
        'destino',
    ];

    public function acompaniante()
    {
        return $this->hasMany(Acompaniante::class, 'conductor_id');
    }


    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class);
    }
}
