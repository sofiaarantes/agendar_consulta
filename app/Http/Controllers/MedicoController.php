<?php

namespace App\Http\Controllers;

use App\Models\Especialidade;
use App\Models\Medico;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicoController extends Controller
{
    public function index()
    {
        if(Auth::user()->tipo_usuario == 1){ // Paciente
            $especialidades = Especialidade::all();
            $medicos = Medico::with('usuario')->get();
            return view('pacientes/medicos', compact('medicos', 'especialidades'));
        }
        else{ // Médico
            $medicos = Medico::with('usuario')->get();
            return view('medicos/index', compact('medicos'));
        }
    }

    public function create()
    {
        $usuarios = User::where('tipo_usuario', 2)->get();
        $especialidades = Especialidade::all();
        return view('medicos/create', compact('usuarios', 'especialidades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'crm' => 'required|unique:medicos,crm|max:30',
            'clinica' => 'required|max:150',
            'status' => 'pendente',
            'especialidade_id' => 'exists:especialidades,id',
            'usuario_id' => 'required|exists:users,id'
        ]);

        Medico::create($request->all());

        return redirect()->route('login')->with('success', 'Médico criado com sucesso! Aguarde aprovação do administrador.');
    }

    public function show($id)
    {
        $medico = Medico::with('agendas.consultas')->findOrFail($id);

        // Pegar apenas consultas com status 'disponivel'
        $horariosDisponiveis = $medico->agendas->flatMap(function($agenda) {
            return $agenda->consultas->where('status', 'disponivel');
        });

        return view('medicos.show', compact('medico', 'horariosDisponiveis'));
    }

    public function edit($id)
    {
        $medico = Medico::findOrFail($id);
        return view('medicos/edit', compact('medico'));
    }

    public function update(Request $request, $id)
    {
        $medico = Medico::with('usuario')->findOrFail($id);

        // Validação
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $medico->usuario->id,
            'telefone' => 'nullable|string|max:20',
            'especialidade' => 'nullable|string|max:100',
            'crm' => 'nullable|string|max:30|unique:medicos,crm,' . $medico->id,
            'clinica' => 'nullable|string|max:150',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        $dataUsuario = [
            'name' => $request->nome,
            'email' => $request->email,
            'telefone' => $request->telefone,
        ];

        if ($request->hasFile('profile_photo')) {
            $dataUsuario['profile_photo_path'] = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        $medico->usuario->update($dataUsuario);

        $dadosMedico = [
            'especialidade' => $request->especialidade,
            'crm' => $request->crm,
            'clinica' => $request->clinica,
        ];

        // Se alterou algum dado profissional, muda status para pendente
        if($request->especialidade != $medico->especialidade ||
        $request->crm != $medico->crm ||
        $request->clinica != $medico->clinica) {
            $dadosMedico['status'] = 'pendente';
        }

        $medico->update($dadosMedico);

        return redirect()->route('medicos.edit', $medico->id)->with('success', 'Dados do médico atualizados com sucesso!');
    }

    public function destroy($medico_id)
    {
        $medico = Medico::findOrFail($medico_id);

        // Busca o usuário vinculado ao paciente enviado para deleção
        $usuario = $medico->usuario;
        $medico->delete();

        // Se o usuário existir, deleta também
        if ($usuario) {
            $usuario->delete();
        }

        return redirect()->route('medicos.index')->with('success', 'Médico deletado com sucesso!');
    }

    public function autenticarMedico()
    {
        // Manda para a view os médicos com status 'pendente'
        $medicos = Medico::where('status', 'pendente')->get();
        return view('medicos/autenticar', compact('medicos'));
    }
    
    public function aprovar(Request $request)
    {
        $request->validate([
            'medico_id' => 'required|exists:medicos,id',
            'status' => 'required|in:aprovado,rejeitado',
        ]);

        $medico = Medico::findOrFail($request->medico_id);
        $medico->status = $request->status;
        $medico->save();

        return back()->with('success', "Médico {$request->status} com sucesso!");
    }
}