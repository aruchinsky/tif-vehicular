<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Acompaniante extends Model
{
    use HasFactory;

    protected $table = 'acompaniante';

    protected $fillable = [
        'dni_acompaniante',
        'nombre_apellido',
        'domicilio',
        'tipo_acompaniante',
        'conductor_id',
    ];

    public function conductor()
    {
        return $this->belongsTo(Conductor::class, 'conductor_id');
    }
}
