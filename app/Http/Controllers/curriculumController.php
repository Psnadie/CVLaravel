<?php

namespace App\Http\Controllers;

use App\Models\curriculumModel;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;


class CurriculumController extends Controller
{
    public function index(): View
    {
    $curriculos = curriculumModel::all();
        return view('curriculos.index', compact('curriculos'));
    }

    public function create(): View
    {
        return view('curriculos.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nombre'     => 'required|string|max:60',
            'apellido'   => 'required|string|max:60',
            'telefono'   => 'nullable|string|max:20',
            'correo'     => 'required|email|max:100|unique:curriculos,correo',
            'fecha_nac'  => 'nullable|date',
            'nota_med'   => 'nullable|numeric|min:0|max:10',
            'formacion'  => 'nullable|string',
            'habilidades'=> 'nullable|string',
            'image'      => 'nullable|image|max:2048',
        ]);

    $curriculo = new curriculumModel($data);
        $curriculo->save();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $filename = $curriculo->id . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('curriculos', $filename, 'public');
            $curriculo->path = $path;
            $curriculo->save();
        }

        return redirect()->route('curriculos.index')->with('success', 'Currículum creado.');
    }

    public function show(curriculumModel $curriculo): View
    {
        return view('curriculos.show', compact('curriculo'));
    }

    public function edit(curriculumModel $curriculo): View
    {
        return view('curriculos.edit', compact('curriculo'));
    }

    public function update(Request $request, curriculumModel $curriculo): RedirectResponse
    {
        $data = $request->validate([
            'nombre'     => 'required|string|max:60',
            'apellido'   => 'required|string|max:60',
            'telefono'   => 'nullable|string|max:20',
            'correo'     => 'required|email|max:100|unique:curriculos,correo,' . $curriculo->id,
            'fecha_nac'  => 'nullable|date',
            'nota_med'   => 'nullable|numeric|min:0|max:10',
            'formacion'  => 'nullable|string',
            'habilidades'=> 'nullable|string',
            'image'      => 'nullable|image|max:2048',
        ]);

        $curriculo->fill($data);
        $curriculo->save();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $filename = $curriculo->id . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('curriculos', $filename, 'public');
            $curriculo->path = $path;
            $curriculo->save();
        }

        return redirect()->route('curriculos.show', $curriculo)->with('success', 'Currículum actualizado.');
    }

    function destroy(curriculumModel $curriculum) {
        try {
            $result = $curriculum->delete();
            $message = 'The curriculum has been deleted.';
        } catch(\Exception $e) {
            $result = false;
            $message = 'The curriculum has not been deleted.';
        }
        $messageArray = [
            'general' => $message
        ];
        if($result) {
            return redirect()->route('blog.index')->with($messageArray);
        } else {
            return back()->withInput()->withErrors($messageArray);
        }
    }
}
