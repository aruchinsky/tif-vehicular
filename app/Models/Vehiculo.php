<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehiculo extends Model
{
    use HasFactory;

    protected $table = 'vehiculo';

    protected $fillable = [
        'fecha_hora_control',
        'marca_modelo',
        'dominio',
        'color',
        'conductor_id',
        'personal_control_id',
    ];

    public function conductor()
    {
        return $this->belongsTo(Conductor::class, 'conductor_id');
    }

    public function personalControl()
    {
        return $this->belongsTo(PersonalControl::class, 'personal_control_id');
    }

    public function novedades()
    {
        return $this->hasMany(Novedad::class, 'vehiculo_id');
    }
}
