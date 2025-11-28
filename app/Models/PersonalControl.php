<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PersonalControl extends Model
{
    use HasFactory;

    protected $table = 'personal_control';

    protected $fillable = [
        'nombre_apellido',
        'lejago_personal',
        'dni',
        'jerarquia',
        'cargo_id',
        'movil',
        'fecha_control',
        'hora_inicio',
        'hora_fin',
        'lugar',
        'ruta',
        'user_id',
    ];

    public function cargo()
    {
        return $this->belongsTo(CargoPolicial::class, 'cargo_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class, 'personal_control_id');
    }

    public function productividad()
    {
        return $this->hasMany(Productividad::class, 'personal_control_id');
    }
}
