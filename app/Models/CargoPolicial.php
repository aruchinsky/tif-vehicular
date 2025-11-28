<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CargoPolicial extends Model
{
    protected $table = 'cargos_policiales';

    protected $fillable = [
        'nombre',
    ];

    public function personal()
    {
        return $this->hasMany(PersonalControl::class, 'cargo_id');
    }
}
