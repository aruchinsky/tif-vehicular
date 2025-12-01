<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ControlPersonal extends Model
{
    use HasFactory;

    protected $table = 'control_personal';

    protected $fillable = [
        'control_id',
        'personal_id',
        'rol_operativo_id',
    ];

    public function control()
    {
        return $this->belongsTo(ControlPolicial::class, 'control_id');
    }

    public function personal()
    {
        return $this->belongsTo(Personal::class, 'personal_id');
    }

    public function rolOperativo()
    {
        return $this->belongsTo(CargoPolicial::class, 'rol_operativo_id');
    }


    public function productividad()
    {
        return $this->hasOne(Productividad::class, 'control_personal_id');
    }

    public function vehiculosRegistrados()
    {
        return $this->hasMany(Vehiculo::class, 'operador_id');
    }
}
