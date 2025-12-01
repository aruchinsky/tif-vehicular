<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class ControlPolicial extends Model
{
    use HasFactory;

    protected $table = 'controles_policiales';

    protected $fillable = [
        'administrador_id',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'lugar',
        'ruta',
        'movil_asignado',
    ];

    public function administrador()
    {
        return $this->belongsTo(User::class, 'administrador_id');
    }

    public function personalAsignado()
    {
        return $this->hasMany(ControlPersonal::class, 'control_id');
    }

    public function vehiculosControlados()
    {
        return $this->hasMany(Vehiculo::class, 'control_id');
    }
}
