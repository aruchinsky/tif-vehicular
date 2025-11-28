<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',   // Rol principal del sistema (ADMIN / CONTROL)
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
    // RELACIONES DE NEGOCIO
    // ----------------------------------------------------------------

    // Relación con PersonalControl
    public function personalControls()
    {
        return $this->hasMany(PersonalControl::class, 'user_id');
    }

    public function getPersonalControlId()
    {
        $control = $this->personalControls()->first();
        return $control ? $control->id : null;
    }


    // ----------------------------------------------------------------
    // ROLES PRINCIPALES DEL SISTEMA (role_id)
    // ----------------------------------------------------------------

    public function isAdmin(): bool
    {
        return $this->role_id === 1;
    }

    public function isControl(): bool
    {
        return $this->role_id === 2;
    }
}
