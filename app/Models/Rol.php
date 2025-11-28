<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = [
        'nombre',
    ];

    // ⭐ NUEVA RELACIÓN: Un Rol (padre) tiene muchos Usuarios (hijos).
    // Esto se alinea con la columna 'role_id' que ahora tienes en la tabla 'users'.
    public function users()
    {
        // Asume que la clave foránea en la tabla 'users' es 'rol_id' o 'role_id'.
        // Laravel buscará por defecto 'rol_id' ya que el modelo se llama 'Rol'.
        return $this->hasMany(User::class);
    }

    // 🔁 Relación con PersonalControl (un rol puede tener muchos agentes)
    public function personalControls()
    {
        return $this->hasMany(PersonalControl::class, 'rol_id');
    }
}