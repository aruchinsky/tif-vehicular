<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CargoPolicial extends Model
{
    use HasFactory;

    protected $table = 'cargos_policiales';

    protected $fillable = ['nombre'];

    public function personal()
    {
        return $this->hasMany(Personal::class, 'cargo_id');
    }

    public function rolesOperativosAsignados()
    {
        return $this->hasMany(ControlPersonal::class, 'rol_operativo_id');
    }
}
