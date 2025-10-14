<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Especialidade;

class EspecialidadeController extends Controller
{
    public function index()
    {
        $especialidades = Especialidade::all();
        return view('especialidades.index', compact('especialidades'));
    }

    public function create()
    {
        return view('especialidades.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'especialidade' => 'required|string|max:100|unique:especialidades,especialidade',
        ]);

        Especialidade::create([
            'especialidade' => $request->especialidade
        ]);

        return redirect()->route('especialidades.index')->with('success', 'Especialidade cadastrada com sucesso!');
    }

    public function edit($id)
    {
        $especialidade = Especialidade::findOrFail($id);
        return view('especialidades/edit', compact('especialidade'));
    }

    public function update(Request $request, $id)
    {
        $especialidade = Especialidade::findOrFail($id);

        $validated = $request->validate([
            'especialidade' => 'required|string|max:100|unique:especialidades,especialidade',
        ]);

        // Atualiza dados da especialidade
        $especialidade->update($validated);

        return redirect()->route('especialidades.index')->with('success', 'Agenda atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $especialidade = Especialidade::findOrFail($id);
        $especialidade->delete(); 
        return redirect()->route('especialidades.index')->with('success', 'Especialidade removida com sucesso!');
    }
}
