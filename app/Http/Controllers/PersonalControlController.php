<?php

namespace App\Http\Controllers;

use App\Models\PersonalControl;
use App\Models\CargoPolicial;
use App\Models\User;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PersonalControlController extends Controller
{
    /**
     * Listado general
     */
    public function index()
    {
        $personalControls = PersonalControl::with(['cargo', 'usuario'])->get();

        return view('modules.PersonalControl.index', compact('personalControls'));
    }

    /**
     * Formulario de creación
     */
    public function create()
    {
        $roles = Rol::all();
        $cargos = CargoPolicial::all();
        $users = User::all(['id', 'name', 'email']);

        return view('modules.PersonalControl.create', compact('roles', 'cargos', 'users'));
    }

    /**
     * Formulario de asignaciones del usuario autenticado
     */
    public function rutaAsignada()
    {
        $userId = auth()->id();

        $personalControls = PersonalControl::where('user_id', $userId)
            ->orderBy('fecha_control', 'desc')
            ->get();

        return view('modules.PersonalControl.RutaAsignada', compact('personalControls'));
    }

    /**
     * Guardar nuevo personal
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_apellido'   => 'required|string|max:255',
            'lejago_personal'   => 'required|string|max:50|unique:personal_control,lejago_personal',
            'dni'               => 'required|numeric|digits_between:7,10|unique:personal_control,dni',
            'jerarquia'         => 'nullable|string|max:100',
            'cargo_id'          => 'nullable|exists:cargos_policiales,id',
            'movil'             => 'nullable|string|max:255',
            'fecha_control'     => 'required|date',
            'hora_inicio'       => 'required|date_format:H:i',
            'hora_fin'          => 'required|date_format:H:i',
            'lugar'             => 'required|string|max:255',
            'ruta'              => 'nullable|string|max:255',

            // Usuario
            'user_option'       => 'required|in:new,existing',
            'existing_user_id'  => 'nullable|required_if:user_option,existing|exists:users,id',

            // Nuevo usuario
            'user_name'         => 'required_if:user_option,new|string|max:255',
            'user_email'        => [
                'required_if:user_option,new',
                'nullable',
                'email',
                Rule::unique('users', 'email')
            ],
            'user_password'     => 'required_if:user_option,new|string|min:8|max:255',

            'rol_id'            => 'required|exists:roles,id',
        ]);

        DB::transaction(function () use ($validated) {

            /** -------------------------
             *  CREAR O ASOCIAR USUARIO
             * ------------------------- */
            if ($validated['user_option'] === 'new') {

                $user = User::create([
                    'name'      => $validated['user_name'],
                    'email'     => $validated['user_email'],
                    'password'  => Hash::make($validated['user_password']),
                    'role_id'   => $validated['rol_id'],
                ]);

                $user_id = $user->id;

            } else {

                $user_id = $validated['existing_user_id'];

                $user = User::find($user_id);
                if ($user && $user->role_id != $validated['rol_id']) {
                    $user->role_id = $validated['rol_id'];
                    $user->save();
                }
            }

            /** -------------------------
             *   CREAR PERSONAL CONTROL
             * ------------------------- */

            $data = $validated;
            unset(
                $data['user_option'],
                $data['existing_user_id'],
                $data['user_name'],
                $data['user_email'],
                $data['user_password'],
                $data['rol_id']
            );

            $data['user_id'] = $user_id;

            PersonalControl::create($data);
        });

        return redirect()->route('personalcontrol.index')
            ->with('success', 'Personal de control registrado correctamente.');
    }

    /**
     * Mostrar detalle
     */
    public function show(PersonalControl $personal_control)
    {
        return view('modules.PersonalControl.show', compact('personal_control'));
    }

    /**
     * Formulario de edición
     */
    public function edit(PersonalControl $personal_control)
    {
        $roles = Rol::all();
        $cargos = CargoPolicial::all();

        return view('modules.PersonalControl.edit', compact('personal_control', 'roles', 'cargos'));
    }

    /**
     * Actualizar personal
     */
    public function update(Request $request, PersonalControl $personal_control)
    {
        $validated = $request->validate([
            'nombre_apellido'   => 'required|string|max:255',
            'lejago_personal'   => 'required|string|max:50|unique:personal_control,lejago_personal,' . $personal_control->id,
            'dni'               => 'required|numeric|digits_between:7,10|unique:personal_control,dni,' . $personal_control->id,
            'jerarquia'         => 'nullable|string|max:100',
            'cargo_id'          => 'nullable|exists:cargos_policiales,id',
            'movil'             => 'nullable|string|max:255',
            'fecha_control'     => 'required|date',
            'hora_inicio'       => 'required|date_format:H:i',
            'hora_fin'          => 'required|date_format:H:i',
            'lugar'             => 'required|string|max:255',
            'ruta'              => 'nullable|string|max:255',
        ]);

        $personal_control->update($validated);

        return redirect()->route('personalcontrol.index')->with('success', 'Personal actualizado correctamente.');
    }

    /**
     * Eliminar personal
     */
    public function destroy(PersonalControl $personal_control)
    {
        $personal_control->delete();

        return redirect()->route('personalcontrol.index')->with('success', 'Registro eliminado correctamente.');
    }
}
