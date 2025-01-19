<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    // Mostrar todos los usuarios activos
    public function index()
    {
        $usuarios = Usuario::where('estado', 'activo')->get(); // Filtrar usuarios activos
        return view('index', ['usuarios' => $usuarios]); // Retornar vista con usuarios
    }

    // Mostrar todos los usuarios desactivados
    public function usuario()
    {
        $usuarios = Usuario::where('estado', 'desactivado')->get(); // Filtrar usuarios desactivados
        return view('usuario', ['usuarios' => $usuarios]); // Retornar vista con usuarios
    }

    // Desactivar un usuario por ID
    public function desactivar($id)
    {
        $usuario = Usuario::findOrFail($id); // Buscar usuario por ID
        $usuario->estado = 'desactivado'; // Cambiar estado a desactivado
        $usuario->save(); // Guardar cambios

        return redirect()->route('index')->with('success', 'Usuario desactivado correctamente');
    }

    // Activar un usuario por ID
    public function activar($id)
    {
        $usuario = Usuario::findOrFail($id); // Buscar usuario por ID
        $usuario->estado = 'activo'; // Cambiar estado a activo
        $usuario->save(); // Guardar cambios

        return redirect()->route('usuarios.desactivados')->with('success', 'Usuario activado correctamente');
    }

    // Obtener datos de un usuario para edición
    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id); // Buscar usuario por ID
        return response()->json($usuario); // Retornar datos como JSON
    }

    // Actualizar datos de un usuario
    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id); // Buscar usuario por ID

        // Validar datos del formulario
        $validated = $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Actualizar campos del usuario
        $usuario->nombres = $validated['nombres'];
        $usuario->apellidos = $validated['apellidos'];
        $usuario->telefono = $validated['telefono'];

        // Procesar foto si fue subida
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('fotos', 'public');
            $usuario->foto = basename($path);
        }

        $usuario->save(); // Guardar cambios

        return redirect()->route('index')->with('success', 'Usuario actualizado correctamente');
    }

    // Crear un nuevo usuario
    public function store(Request $request)
    {
        // Validar datos del formulario
        $validated = $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Crear instancia de usuario
        $usuario = new Usuario();
        $usuario->nombres = $validated['nombres'];
        $usuario->apellidos = $validated['apellidos'];
        $usuario->telefono = $validated['telefono'];

        // Procesar foto si fue subida
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('fotos', 'public');
            $usuario->foto = basename($path);
        }

        $usuario->save(); // Guardar nuevo usuario

        return redirect()->route('index')->with('success', 'Usuario agregado correctamente');
    }
}
