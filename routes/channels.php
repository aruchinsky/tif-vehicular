<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('admin.alertas', function ($user) {
    return $user->isAdmin(); // true solo si es rol administrador
});