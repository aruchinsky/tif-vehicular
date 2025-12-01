<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasProfilePhoto;
    use TwoFactorAuthenticatable;
    use HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id', // Rol principal del sistema
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ----------------------------------------------------------------
    // RELACIONES CORRECTAS
    // ----------------------------------------------------------------

    // Relación correcta entre USER → PERSONAL
    public function personal()
    {
        return $this->hasOne(Personal::class, 'user_id');
    }

    // Controles creados por el Administrador
    public function controlesCreados()
    {
        return $this->hasMany(ControlPolicial::class, 'administrador_id');
    }

    // ----------------------------------------------------------------
    // ROLES PRINCIPALES (role_id)
    // ----------------------------------------------------------------

    public function isSuperUsuario(): bool
    {
        return $this->role_id === 0; // si lo usás
    }

    public function isAdmin(): bool
    {
        return $this->role_id === 1;
    }

    public function isOperador(): bool
    {
        return $this->role_id === 2;
    }
}
