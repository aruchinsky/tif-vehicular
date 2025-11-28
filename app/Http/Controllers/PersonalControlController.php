<?php

namespace App\Http\Controllers;

use App\Models\PersonalControl;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PersonalControlController extends Controller
{
    /**
     * Muestra una lista de recursos. (VIEW)
     */
    public function index()
    {
        // 1. Obtener los datos con su relación
        $personalControls = PersonalControl::with('rol')->get();

        // 2. Devolver la vista con los datos
        return view('modules.PersonalControl.index', compact('personalControls'));
    }

    /**
     * 🆕 Muestra el formulario para crear un nuevo recurso. (VIEW)
     */
    public function create()
    {
        $roles = \App\Models\Rol::all();
        // Obtener usuarios existentes para la opción de asociar
        $users = User::all(['id', 'name', 'email']); 

        /**  OBTENER ENUM DE rol_en_control */
        $enumData = DB::select("SHOW COLUMNS FROM personal_control LIKE 'rol_en_control'");
        preg_match("/^enum\((.*)\)$/", $enumData[0]->Type, $matches);

        $enumValues = array_map(function ($value) {
            return trim($value, "'");
        }, explode(',', $matches[1]));

        return view('modules.PersonalControl.create', compact('roles', 'users', 'enumValues'));
    }

    public function rutaAsignada()
    {
        // 1. Obtener el ID del usuario autenticado
        $userId = auth()->id();

        // 2. Buscar TODOS los registros de PersonalControl asociados a ese usuario.
        $personalControls = PersonalControl::where('user_id', $userId)
                                         ->orderBy('fecha_control', 'desc') // Opcional: ordenar por fecha
                                        ->get();
        
        // 3. Devolver la nueva vista
        return view('modules.PersonalControl.RutaAsignada', compact('personalControls'));
    }

    /**
     * 💾 Almacena un recurso recién creado. (ACTION)
     */
    public function store(Request $request)
    {
        // 1. Validaciones
        $validated = $request->validate([
            'nombre_apellido'   => 'required|string|max:255',
            'lejago_personal'   => 'required|string|max:50',
            // DNI es unique en PersonalControl
            'dni'               => 'required|numeric|digits_between:7,10|unique:personal_control,dni', 
            'jerarquia'         => 'nullable|string|max:100',
            'rol_en_control'    => 'nullable|string|max:100',
            'movil'             => 'nullable|string|max:255',
            'fecha_control'     => 'nullable|date',
            'hora_inicio'       => 'nullable|date_format:H:i',
            'hora_fin'          => 'nullable|date_format:H:i',
            'lugar'             => 'nullable|string|max:255',
            'ruta'              => 'nullable|string|max:255',
            
            // Campos para el usuario (nuevos)
            'user_option'       => 'required|in:new,existing',
            'existing_user_id'  => 'nullable|required_if:user_option,existing|exists:users,id',
            
            // Campos solo si se crea un usuario nuevo
            'user_name'         => 'required_if:user_option,new|string|max:255',
            'user_email'        => [
                                        'required_if:user_option,new', 
                                        'nullable', 
                                        'email', 
                                        'max:255', 
                                        Rule::unique('users', 'email')
                                    ],
            'user_password'     => 'required_if:user_option,new|string|min:8|max:255',
            
            //  VALIDACIÓN DEL ROL DE USUARIO
            'rol_id'            => 'required|exists:roles,id',
        ]);


        // 2. Lógica de creación/asociación de Usuario dentro de una transacción
        DB::transaction(function () use ($validated, $request) {
            $user_id = null;
            
            // ⭐ ELIMINAMOS la línea que forzaba el role_id = 2.
            // Ahora, el role_id se toma directamente del formulario:
            $role_id_from_form = $validated['rol_id']; 

            if ($validated['user_option'] === 'new') {
                // Crear nuevo usuario
                $user = User::create([
                    'name'          => $validated['user_name'],
                    'email'         => $validated['user_email'],
                    'password'      => Hash::make($validated['user_password']),
                    // ⭐ CORRECCIÓN CLAVE: Usamos el ID de rol que vino del formulario
                    'role_id'       => $role_id_from_form, 
                ]);
                
                $user_id = $user->id;

            } else {
                // Usar usuario existente
                $user_id = $validated['existing_user_id'];
                
                // Actualizamos el rol del usuario existente (si es necesario)
                $user = User::find($user_id);
                
                // CORRECCIÓN CLAVE: Actualizamos el role_id del usuario existente con el del formulario
                if ($user && $user->role_id != $role_id_from_form) {
                    $user->role_id = $role_id_from_form;
                    $user->save();
                }
            }
            
            // 3. Crear el PersonalControl
            $personalControlData = array_merge($validated, [
                'user_id' => $user_id,
            ]);

            // Eliminar campos de usuario y ROL ID que NO pertenecen a PersonalControl.
            // Esto incluye el 'rol_id' que usamos para el usuario, para evitar errores en la tabla 'personal_control'.
            unset(
                $personalControlData['user_option'], 
                $personalControlData['existing_user_id'], 
                $personalControlData['user_name'], 
                $personalControlData['user_email'], 
                $personalControlData['user_password'], 
                $personalControlData['rol_id'] // Campo que se usó para el usuario, no debe ir aquí
            );

            PersonalControl::create($personalControlData);
        });


        // Redirigir a la lista de registros con un mensaje de éxito
        return redirect()->route('personalcontrol.index')->with('success', 'Personal de control y usuario registrado/asociado correctamente.');
    }

    /**
     * ✏️ Muestra el formulario para editar el recurso especificado. (VIEW)
     */
    public function edit(PersonalControl $personal_control) // Usamos Inyección de Modelo
    {
        // La variable $personal_control ya tiene el registro cargado gracias a la inyección
        $roles = \App\Models\Rol::all();

        return view('modules.PersonalControl.edit', compact('personal_control', 'roles'));
    }

    public function show(PersonalControl $personal_control)
    {
        return view('modules.PersonalControl.show', compact('personal_control'));
    }

    /**
     * 💾 Actualiza el recurso especificado. (ACTION)
     */
    public function update(Request $request, PersonalControl $personal_control)
    {
        // El código de validación y actualización necesita un ajuste en 'dni'
        $validated = $request->validate([
            'nombre_apellido'   => 'sometimes|required|string|max:255',
            'lejago_personal'   => 'sometimes|required|string|max:50',
            // Importante: Ignorar el DNI del registro actual para la validación unique
            'dni'               => 'sometimes|required|numeric|digits_between:7,10|unique:personal_control,dni,' . $personal_control->id,
            'jerarquia'         => 'nullable|string|max:100',
            'rol_en_control'    => 'nullable|string|max:100',
            'movil' => 'nullable|string|max:255',
            'fecha_control'     => 'nullable|date',
            'hora_inicio'       => 'nullable|date_format:H:i',
            'hora_fin'          => 'nullable|date_format:H:i',
            'lugar'             => 'nullable|string|max:255',
            // ... (resto de validaciones)
        ]);

        $personal_control->update($validated);

        return redirect()->route('personalcontrol.index')->with('success', 'Personal de control actualizado correctamente.');
    }

    /**
     * 🗑️ Elimina el recurso especificado. (ACTION)
     */
    public function destroy(PersonalControl $personal_control)
    {
        $personal_control->delete();

        return redirect()->route('personalcontrol.index')->with('success', 'Personal eliminado correctamente.');
    }
}