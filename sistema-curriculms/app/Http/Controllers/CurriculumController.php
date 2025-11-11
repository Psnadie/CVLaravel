<?php

namespace App\Http\Controllers;

use App\Models\Curriculum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CurriculumController extends Controller
{
    // 1. index - Listar todos los currículums
    public function index()
    {
        $curricula = Curriculum::latest()->paginate(10);
        return view('curricula.index', compact('curricula'));
    }

    // 2. create - Mostrar formulario de creación
    public function create()
    {
        return view('curricula.create');
    }

    // 3. store - Guardar nuevo currículum
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'correo' => 'required|email|unique:curricula,correo',
            'fecha_nacimiento' => 'required|date|before:today',
            'nota_media' => 'required|numeric|min:0|max:10',
            'experiencia' => 'required|string',
            'formacion' => 'required|string',
            'habilidades' => 'required|string',
            'fotografia' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'nombre.required' => 'El nombre es obligatorio',
            'apellidos.required' => 'Los apellidos son obligatorios',
            'correo.unique' => 'Este correo ya está registrado',
            'fecha_nacimiento.before' => 'La fecha de nacimiento debe ser anterior a hoy',
            'nota_media.min' => 'La nota media debe ser entre 0 y 10',
            'nota_media.max' => 'La nota media debe ser entre 0 y 10'
        ]);

        if ($request->hasFile('fotografia')) {
            $validated['fotografia'] = $request->file('fotografia')->store('fotografias', 'public');
        }

        Curriculum::create($validated);

        return redirect()->route('curricula.index')
            ->with('success', 'Currículum registrado exitosamente');
    }

    // 4. show - Mostrar un currículum específico
    public function show(Curriculum $curriculum)
    {
        return view('curricula.show', compact('curriculum'));
    }

    // 5. edit - Mostrar formulario de edición
    public function edit(Curriculum $curriculum)
    {
        return view('curricula.edit', compact('curriculum'));
    }

    // 6. update - Actualizar currículum
    public function update(Request $request, Curriculum $curriculum)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'correo' => 'required|email|unique:curricula,correo,' . $curriculum->id,
            'fecha_nacimiento' => 'required|date|before:today',
            'nota_media' => 'required|numeric|min:0|max:10',
            'experiencia' => 'required|string',
            'formacion' => 'required|string',
            'habilidades' => 'required|string',
            'fotografia' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('fotografia')) {
            // Eliminar fotografía anterior si existe
            if ($curriculum->fotografia) {
                Storage::disk('public')->delete($curriculum->fotografia);
            }
            $validated['fotografia'] = $request->file('fotografia')->store('fotografias', 'public');
        }

        $curriculum->update($validated);

        return redirect()->route('curricula.index')
            ->with('success', 'Currículum actualizado exitosamente');
    }

    // 7. destroy - Eliminar currículum
    public function destroy(Curriculum $curriculum)
    {
        if ($curriculum->fotografia) {
            Storage::disk('public')->delete($curriculum->fotografia);
        }

        $curriculum->delete();

        return redirect()->route('curricula.index')
            ->with('success', 'Currículum eliminado exitosamente');
    }
}