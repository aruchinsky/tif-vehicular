<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Personal;
use App\Models\CargoPolicial;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    // =========================================================================
    // LISTADO
    // =========================================================================
    public function index()
    {
        $usuarios = User::with(['personal', 'roles'])
            ->orderBy('name')
            ->paginate(15);

        return view('modules.usuarios.index', compact('usuarios'));
    }

    // =========================================================================
    // FORMULARIO CREAR
    // =========================================================================
    public function create()
    {
        // Solo estos roles para el sistema
        $roles = Role::whereIn('name', ['SUPERUSUARIO', 'ADMINISTRADOR', 'OPERADOR'])
            ->orderBy('name')
            ->get();

        // Personal que aún no tiene usuario asociado
        $personalSinUsuario = Personal::whereNull('user_id')
            ->orderBy('nombre_apellido')
            ->get();

        return view('modules.usuarios.create', compact('roles', 'personalSinUsuario'));
    }

    // =========================================================================
    // GUARDAR NUEVO
    // =========================================================================
    public function store(Request $request)
    {
        // ------------------------------
        // VALIDACIÓN INICIAL
        // ------------------------------
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],

            // nombre del rol spatie
            'rol'      => ['required', Rule::in(['SUPERUSUARIO', 'ADMINISTRADOR', 'OPERADOR'])],

            // gestión de personal
            'modo_personal' => ['nullable', Rule::in(['ninguno', 'existente', 'nuevo'])],

            // personal existente
            'personal_id'   => ['nullable', 'integer', 'exists:personal,id'],

            // datos nuevo personal
            'nombre_apellido' => ['required_if:modo_personal,nuevo', 'nullable', 'string', 'max:255'],
            'dni'             => ['required_if:modo_personal,nuevo', 'nullable', 'string', 'max:20', 'unique:personal,dni'],
            'legajo'          => ['required_if:modo_personal,nuevo', 'nullable', 'string', 'max:50', 'unique:personal,legajo'],
            'jerarquia'       => ['nullable', 'string', 'max:100'],
            'movil'           => ['nullable', 'string', 'max:100'],
        ], [
            'rol.required'                    => 'Debe seleccionar un rol.',
            'rol.in'                          => 'El rol seleccionado no es válido.',
            'nombre_apellido.required_if'     => 'El nombre y apellido del personal es obligatorio.',
            'dni.required_if'                 => 'El DNI del personal es obligatorio.',
            'dni.unique'                      => 'Ya existe un personal con ese DNI.',
            'legajo.required_if'              => 'El legajo del personal es obligatorio.',
            'legajo.unique'                   => 'Ya existe un personal con ese legajo.',
            'personal_id.exists'              => 'El personal seleccionado no existe.',
        ]);

        $rolName = $validated['rol'];

        // ------------------------------
        // REGLAS SEGÚN ROL
        // ------------------------------
        if ($rolName === 'SUPERUSUARIO') {
            // SUPERUSUARIO NO lleva personal
            $validated['modo_personal'] = 'ninguno';
        } else {
            // ADMINISTRADOR u OPERADOR → debe tener personal
            if (empty($validated['modo_personal']) || $validated['modo_personal'] === 'ninguno') {
                return back()
                    ->withErrors(['modo_personal' => 'Para este rol es obligatorio vincular un personal (existente o nuevo).'])
                    ->withInput();
            }
        }

        // ------------------------------
        // CREAR USUARIO
        // ------------------------------
        /** @var \Spatie\Permission\Models\Role $role */
        $role = Role::where('name', $rolName)->firstOrFail();

        $user = new User();
        $user->name     = $validated['name'];
        $user->email    = $validated['email'];
        $user->password = $validated['password']; // se hashea por el cast de User
        $user->role_id  = $role->id; // sincronizar con tabla roles (Spatie)

        $user->save();

        // Asignar rol Spatie
        $user->syncRoles([$rolName]);

        // ------------------------------
        // GESTIÓN PERSONAL
        // ------------------------------
        if ($rolName === 'ADMINISTRADOR' || $rolName === 'OPERADOR') {

            $personal = null;

            // MODO: EXISTENTE
            if ($validated['modo_personal'] === 'existente') {

                $personal = Personal::findOrFail($validated['personal_id']);

                if (!is_null($personal->user_id)) {
                    return back()
                        ->withErrors(['personal_id' => 'Este personal ya tiene un usuario asignado.'])
                        ->withInput();
                }

                $personal->user_id = $user->id;
                $personal->save();
            }

            // MODO: NUEVO
            if ($validated['modo_personal'] === 'nuevo') {

                // cargo_id según rol
                if ($rolName === 'OPERADOR') {
                    $cargoId = CargoPolicial::where('nombre', 'Operador')->value('id');
                } else { // ADMINISTRADOR
                    $cargoId = CargoPolicial::where('nombre', 'Administrador')->value('id');
                }

                $personal = new Personal();
                $personal->nombre_apellido = $validated['nombre_apellido'];
                $personal->dni             = $validated['dni'];
                $personal->legajo          = $validated['legajo'];
                $personal->jerarquia       = $validated['jerarquia'] ?? null;
                $personal->movil           = $validated['movil'] ?? null;
                $personal->cargo_id        = $cargoId;
                $personal->user_id         = $user->id;
                $personal->save();
            }
        }

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    // =========================================================================
    // VER DETALLE
    // =========================================================================
    public function show(User $usuario)
    {
        $usuario->load(['personal', 'roles']);

        return view('modules.usuarios.show', compact('usuario'));
    }

    // =========================================================================
    // FORMULARIO EDITAR
    // =========================================================================
    public function edit(User $usuario)
    {
        $usuario->load(['personal', 'roles']);

        $roles = Role::whereIn('name', ['SUPERUSUARIO', 'ADMINISTRADOR', 'OPERADOR'])
            ->orderBy('name')
            ->get();

        // Personal libre (sin usuario) para permitir asociar en caso que todavía no tenga
        $personalSinUsuario = Personal::whereNull('user_id')
            ->orderBy('nombre_apellido')
            ->get();

        return view('modules.usuarios.edit', compact('usuario', 'roles', 'personalSinUsuario'));
    }

    // =========================================================================
    // ACTUALIZAR
    // =========================================================================
    public function update(Request $request, User $usuario)
    {
        $usuario->load('personal');

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($usuario->id),
            ],

            'password' => ['nullable', 'confirmed', 'min:8'],

            'rol'      => ['required', Rule::in(['SUPERUSUARIO', 'ADMINISTRADOR', 'OPERADOR'])],

            // Para el caso que aún no tenga personal y se quiera asociar
            'modo_personal' => ['nullable', Rule::in(['ninguno', 'existente', 'nuevo'])],
            'personal_id'   => ['nullable', 'integer', 'exists:personal,id'],

            // datos de personal (si ya tiene y se edita, o si se crea nuevo)
            'nombre_apellido' => ['nullable', 'string', 'max:255'],
            'dni'             => ['nullable', 'string', 'max:20', Rule::unique('personal', 'dni')->ignore(optional($usuario->personal)->id)],
            'legajo'          => ['nullable', 'string', 'max:50', Rule::unique('personal', 'legajo')->ignore(optional($usuario->personal)->id)],
            'jerarquia'       => ['nullable', 'string', 'max:100'],
            'movil'           => ['nullable', 'string', 'max:100'],
        ]);

        $rolName = $validated['rol'];

        // ------------------------------
        // ACTUALIZAR USER
        // ------------------------------
        /** @var \Spatie\Permission\Models\Role $role */
        $role = Role::where('name', $rolName)->firstOrFail();

        $usuario->name    = $validated['name'];
        $usuario->email   = $validated['email'];
        $usuario->role_id = $role->id;

        if (!empty($validated['password'])) {
            $usuario->password = $validated['password']; // cast hashed
        }

        $usuario->save();

        $usuario->syncRoles([$rolName]);

        // ------------------------------
        // MANEJO DE PERSONAL SEGÚN ROL
        // ------------------------------
        if ($rolName === 'SUPERUSUARIO') {
            // Si ahora pasa a ser SUPERUSUARIO, se desvincula del personal
            if ($usuario->personal) {
                $usuario->personal->user_id = null;
                $usuario->personal->save();
            }
        } else {
            // ADMINISTRADOR / OPERADOR
            $personal = $usuario->personal;

            // Si ya tiene personal asociado → actualizo datos si vienen
            if ($personal) {
                if (!empty($validated['nombre_apellido'])) {
                    $personal->nombre_apellido = $validated['nombre_apellido'];
                }
                if (!empty($validated['dni'])) {
                    $personal->dni = $validated['dni'];
                }
                if (!empty($validated['legajo'])) {
                    $personal->legajo = $validated['legajo'];
                }
                $personal->jerarquia = $validated['jerarquia'] ?? $personal->jerarquia;
                $personal->movil     = $validated['movil'] ?? $personal->movil;

                // Actualizar cargo según rol
                if ($rolName === 'OPERADOR') {
                    $cargoId = CargoPolicial::where('nombre', 'Operador')->value('id');
                } else {
                    $cargoId = CargoPolicial::where('nombre', 'Administrador')->value('id');
                }
                if ($cargoId) {
                    $personal->cargo_id = $cargoId;
                }

                $personal->save();
            } else {
                // No tiene personal aún → puedo usar modo_personal para crear/asociar

                if (!empty($validated['modo_personal']) && $validated['modo_personal'] !== 'ninguno') {

                    if ($validated['modo_personal'] === 'existente') {
                        $personal = Personal::findOrFail($validated['personal_id']);

                        if (!is_null($personal->user_id)) {
                            return back()
                                ->withErrors(['personal_id' => 'Este personal ya tiene un usuario asignado.'])
                                ->withInput();
                        }

                        $personal->user_id = $usuario->id;
                        $personal->save();
                    }

                    if ($validated['modo_personal'] === 'nuevo') {

                        if ($rolName === 'OPERADOR') {
                            $cargoId = CargoPolicial::where('nombre', 'Operador')->value('id');
                        } else {
                            $cargoId = CargoPolicial::where('nombre', 'Administrador')->value('id');
                        }

                        $nuevoPersonal = new Personal();
                        $nuevoPersonal->nombre_apellido = $validated['nombre_apellido'];
                        $nuevoPersonal->dni             = $validated['dni'];
                        $nuevoPersonal->legajo          = $validated['legajo'];
                        $nuevoPersonal->jerarquia       = $validated['jerarquia'] ?? null;
                        $nuevoPersonal->movil           = $validated['movil'] ?? null;
                        $nuevoPersonal->cargo_id        = $cargoId;
                        $nuevoPersonal->user_id         = $usuario->id;
                        $nuevoPersonal->save();
                    }
                }
            }
        }

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    // =========================================================================
    // ELIMINAR
    // =========================================================================
    public function destroy(User $usuario)
    {
        // Desvincular personal si lo tiene
        if ($usuario->personal) {
            $usuario->personal->user_id = null;
            $usuario->personal->save();
        }

        $usuario->delete();

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
