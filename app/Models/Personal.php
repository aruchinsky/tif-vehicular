<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Personal extends Model
{
    use HasFactory;

    protected $table = 'personal';

    protected $fillable = [
        'nombre_apellido',
        'legajo',
        'dni',
        'jerarquia',
        'cargo_id',
        'movil',
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

    public function controlesAsignados()
    {
        return $this->hasMany(ControlPersonal::class, 'personal_id');
    }
}
