<?php

namespace App\Http\Controllers;

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
            'endereco' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $usuario->name = $request->nome;
        $usuario->email = $request->email;

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
        $name = $request->input('name');
        $especialidade = $request->input('especialidade_id');

        $query = \App\Models\Medico::with('usuario', 'especialidade');

        if ($name) {
            $query->whereHas('usuario', function ($q) use ($name) {
                $q->where('name', 'like', "%$name%");
            });
        }

        if ($especialidade) {
            $query->where('especialidade_id', $especialidade);
        }

        $medicos = $query->get();
        $especialidades = \App\Models\Especialidade::all();

        return view('pacientes.medicos', compact('medicos', 'especialidades'));
    }

}