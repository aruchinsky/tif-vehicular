<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehiculo extends Model
{
    use HasFactory;

    protected $table = 'vehiculo';

    protected $fillable = [
        'control_id',
        'operador_id',
        'conductor_id',
        'fecha_hora_control',
        'marca_modelo',
        'dominio',
        'color',
    ];

    public function control()
    {
        return $this->belongsTo(ControlPolicial::class, 'control_id');
    }

    public function conductor()
    {
        return $this->belongsTo(Conductor::class, 'conductor_id');
    }

    public function novedades()
    {
        return $this->hasMany(Novedad::class, 'vehiculo_id');
    }
}
