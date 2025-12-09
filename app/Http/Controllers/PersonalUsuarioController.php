<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PersonalUsuarioController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'personal_id' => 'required|exists:personal,id',
            'email'       => 'required|email|unique:users,email',
        ]);

        $personal = Personal::find($data['personal_id']);

        // Contraseña = DNI del personal
        $password = $personal->dni;

        $user = User::create([
            'name'     => $personal->nombre_apellido,
            'email'    => $data['email'],
            'password' => $password, // Laravel lo encripta con el cast de modelo User
            'role_id'  => 3, // OPERADOR
        ]);

        // Rol spatie
        $user->syncRoles(['OPERADOR']);

        // Asociar usuario al personal
        $personal->update([ 'user_id' => $user->id ]);

        return response()->json([
            'status'      => 'ok',
            'personal_id' => $personal->id,
            'password'    => $password, // opcional, lo mostramos en pantalla si querés
        ]);
    }
}
