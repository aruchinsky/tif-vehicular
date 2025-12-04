<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('admin.alertas', function ($user) {
    return $user->hasRole('ADMINISTRADOR') || $user->hasRole('SUPERUSUARIO');
});
