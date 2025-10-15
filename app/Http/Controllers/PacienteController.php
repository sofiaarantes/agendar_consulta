<?php

namespace App\Http\Controllers;

use App\Models\Especialidade;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\User;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    public function index()
    {
        $pacientes = Paciente::with('usuario')->get();
        return view('pacientes/index', compact('pacientes'));
    }

    public function create()
    {
        $usuarios = User::where('tipo_usuario', 'paciente')->get();
        return view('pacientes.create', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'data_nascimento' => 'required|date',
            'endereco' => 'required|max:300',
            'usuario_id' => 'required|exists:users,id'
        ]);

        Paciente::create($request->all());

        return redirect()->route('dashboard')->with('success', 'Paciente criado com sucesso!');
    }

    public function show($id)
    {
        $paciente = Paciente::with('usuario', 'consultas')->findOrFail($id);
        return view('pacientes.show', compact('paciente'));
    }

    public function edit($id)
    {
        $paciente = Paciente::with('usuario')->findOrFail($id);
        return view('pacientes/edit', compact('paciente'));
    }

    public function update(Request $request, $id)
    {
        $paciente = Paciente::with('usuario')->findOrFail($id);
        $usuario = $paciente->usuario;

        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$usuario->id,
            'telefone' => 'nullable|string|max:20',
            'endereco' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $usuario->name = $request->nome;
        $usuario->email = $request->email;
        $usuario->telefone = $request->telefone;

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profiles', 'public');
            $usuario->profile_photo_path = $path;
        }

        $usuario->save();

        $paciente->update([
            'endereco' => $request->endereco,
            'data_nascimento' => $request->data_nascimento,
        ]);

        return redirect()->route('pacientes.edit', $paciente->id)
                        ->with('success', 'Perfil atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $paciente = Paciente::findOrFail($id);

        // Busca o usuário vinculado ao paciente enviado para deleção
        $usuario = $paciente->usuario;
        $paciente->delete();

        // Se o usuário existir, deleta também
        if ($usuario) {
            $usuario->delete();
        }

        return redirect()->route('pacientes.index')->with('success', 'Paciente deletado com sucesso!');
    }

    public function buscar(Request $request)
    {
        // Filtro básico
        $query = Medico::where('status', 'verificado')->with('usuario', 'especialidade');

        // Filtro por nome do médico
        if ($request->filled('name')) {
            $query->whereHas('usuario', function($q) use ($request) {
                $q->where('name', 'like', '%'.$request->name.'%');
            });
        }

        // Filtro por especialidade
        if ($request->filled('especialidade_id')) {
            $query->where('especialidade_id', $request->especialidade_id);
        }

        $medicos = $query->get();
        $especialidades = Especialidade::all();

        return view('pacientes/medicos', compact('medicos', 'especialidades'));
    }

}