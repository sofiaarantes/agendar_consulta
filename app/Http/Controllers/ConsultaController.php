<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Notificacao;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultaController extends Controller
{
    public function index(Request $request)
    {
        if(Auth::user()->tipo_usuario == 1){ // Paciente
            $user = Auth::user();
            $paciente_id = $user->paciente->id;

            // Base da query: pegar consultas do paciente logado
            $query = Consulta::with(['agenda.medico.usuario', 'paciente'])
                ->where('paciente_id', $paciente_id)
                ->orderBy('data', 'asc')
                ->orderBy('hora_inicio', 'asc');

            // Filtro por data
            if ($request->filled('data')) {
                $query->whereDate('data', $request->data);
            }

            // Filtro por status
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            $consultas = $query->get();

            return view('pacientes/consultas', compact('consultas'));
        } 
        else{ // Médico
            $user = Auth::user();
            $medico = $user->medico;

            if (!$medico) {
                return redirect()->back()->with('error', 'Médico não encontrado.');
            }

            // Base da query
            $query = Consulta::whereHas('agenda', function ($q) use ($medico) {
                $q->where('medico_id', $medico->id);
            })
            ->with(['agenda', 'paciente'])
            ->orderBy('data', 'asc')
            ->orderBy('hora_inicio', 'asc');

            // Filtro por data
            if ($request->filled('data')) {
                $query->whereDate('data', $request->data);
            }

            // Filtro por status
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            $consultas = $query->get();

            return view('consultas/index', compact('consultas'));
        }
    }

    public function marcar(Request $request)
    {
        $request->validate([
            'consulta_id' => 'required|exists:consultas,id'
        ]);

        $consulta = Consulta::findOrFail($request->consulta_id);
        $consulta->status = 'reservada';
        $consulta->paciente_id = Auth::user()->paciente->id; // assume que paciente está logado
        $consulta->save();

        return redirect()->route('medicos.index')->with('success', 'Consulta marcada com sucesso!');
    }

    public function historico(Request $request)
    {
        // Apenas paciente
        if (Auth::user()->tipo_usuario != 1) {
            return redirect()->back()->with('error', 'Acesso não permitido.');
        }

        $pacienteId = Auth::user()->paciente->id;

        $consultas = Consulta::with(['agenda.medico.usuario', 'agenda.medico.especialidade'])
            ->where('paciente_id', $pacienteId)
            ->where('status', 'realizada')
            ->orderBy('data', 'desc')
            ->orderBy('hora_inicio', 'desc')
            ->get();

        return view('pacientes/historico', compact('consultas'));
    }

    public function marcarComoRealizada($id)
    {
        $consulta = Consulta::findOrFail($id);

        // Somente o médico dono pode atualizar
        if ($consulta->agenda->medico->usuario_id != Auth::id()) {
            return redirect()->back()->with('error', 'Você não tem permissão para alterar esta consulta.');
        }

        if ($consulta->status !== 'reservada') {
            return redirect()->back()->with('error', 'Apenas consultas reservadas podem ser marcadas como realizadas.');
        }

        $consulta->status = 'realizada';
        $consulta->save();

        return redirect()->back()->with('success', 'Consulta marcada como realizada.');
    }

    public function formCancelar($id)
    {
        $consulta = Consulta::findOrFail($id);
        if(Auth::user()->tipo_usuario == 1){ // Paciente
            if ($consulta->paciente_id != Auth::user()->paciente->id) {
                return redirect()->back()->with('error', 'Você não tem permissão para cancelar esta consulta.');
            }
            return view('consultas/cancelarPaciente', compact('consulta'));
        }else if(Auth::user()->tipo_usuario == 2){ // Médico
            if ($consulta->agenda->medico_id != Auth::user()->medico->id) {
                return redirect()->back()->with('error', 'Você não tem permissão para cancelar esta consulta.');
            }
            return view('consultas/cancelarMedico', compact('consulta'));
        }
    }

    public function cancelar(Request $request, $id)
    {
        $request->validate([
            'observacao' => 'nullable|string|max:1000'
        ]);

        $consulta = Consulta::findOrFail($id);
        $agora = Carbon::now();
        $dataHoraConsulta = Carbon::parse($consulta->data . ' ' . $consulta->hora_inicio);

        // Verifica se falta mais de 24h
        if ($dataHoraConsulta->subHours(24)->lte($agora)) {
            return redirect()->back()->with('error', 'Não é possível cancelar a consulta com menos de 24 horas de antecedência.');
        }

        $mensagemBase = " cancelou a consulta marcada para " .
                        Carbon::parse($consulta->data)->format('d/m/Y') .
                        " às {$consulta->hora_inicio}.";

        if (Auth::user()->tipo_usuario == 1) { // Paciente
            if ($consulta->paciente_id != Auth::user()->paciente->id) {
                return redirect()->back()->with('error', 'Você não pode cancelar esta consulta.');
            }

            $mensagem = "O paciente " . Auth::user()->name . $mensagemBase;
            if (!empty($request->observacao)) {
                $mensagem .= " Por motivos de: {$request->observacao}";
            }

            Notificacao::create([
                'usuario_id' => $consulta->agenda->medico->usuario_id,
                'mensagem' => $mensagem,
            ]);

        } else { // Médico
            if ($consulta->agenda->medico_id != Auth::user()->medico->id) {
                return redirect()->back()->with('error', 'Você não tem permissão para cancelar esta consulta.');
            }

            $mensagem = "O médico " . Auth::user()->name . $mensagemBase;
            if (!empty($request->observacao)) {
                $mensagem .= " Por motivos de: {$request->observacao}";
            }

            Notificacao::create([
                'usuario_id' => $consulta->paciente->usuario_id,
                'mensagem' => $mensagem,
            ]);
        }

        $consulta->status = 'cancelada';
        $consulta->observacao = $request->observacao;
        $consulta->save();

        return redirect()->route('consultas.index')->with('success', 'Consulta cancelada com sucesso.');
    }

}



                        // <!-- Gráfico -->
                        // <div class="row mb-4">
                        //     <div class="col-lg-12">
                        //         <div class="card shadow-sm border-0 mt-4">
                        //             <div class="card-header">
                        //                 <h5 class="mb-0">Consultas realizadas por dia</h5>
                        //             </div>
                        //             <div class="card-body">
                        //                 @if($temConsultas)
                        //                     <canvas id="graficoConsultas" height="120"></canvas>
                        //                 @else
                        //                     <p class="text-muted mb-0">Nenhuma consulta realizada neste mês.</p>
                        //                 @endif
                        //             </div>
                        //         </div>
                        //     </div>
                        // </div>