<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consulta;
use App\Models\Notificacao;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request) {
        if(Auth::user()->tipo_usuario == 1){ // Paciente
            $usuario = Auth::user();

            $paciente = $usuario->paciente;

            // Próxima consulta futura
            $proximaConsulta = Consulta::where('paciente_id', $paciente->id)
                ->whereIn('status', ['reservada', 'cancelada'])
                ->whereDate('data', '>=', now()->format('Y-m-d'))
                ->orderBy('data')
                ->orderBy('hora_inicio')
                ->with(['agenda.medico.usuario', 'agenda.medico.especialidade'])
                ->first();

            // Últimas 5 consultas (passadas ou canceladas)
            $ultimasConsultas = Consulta::where('paciente_id', $paciente->id)
                ->with(['agenda.medico.usuario', 'agenda.medico.especialidade'])
                ->orderBy('data', 'desc')
                ->orderBy('hora_inicio', 'desc')
                ->take(5)
                ->get();

            // Contadores
            $totalAgendadas = Consulta::where('paciente_id', $paciente->id)->where('status', 'reservada')->count();
            $totalRealizadas = Consulta::where('paciente_id', $paciente->id)->where('status', 'realizada')->count();
            $totalCanceladas = Consulta::where('paciente_id', $paciente->id)->where('status', 'cancelada')->count();

            $notificacoes = Notificacao::where('usuario_id', Auth::id())
                ->orderByDesc('created_at')
                ->take(10)
                ->get();

            return view('dashboardPaciente', compact( 'proximaConsulta', 'ultimasConsultas',
                'totalAgendadas', 'totalRealizadas', 'totalCanceladas', 'notificacoes'
            ));
        }
        else if(Auth::user()->tipo_usuario == 2) { // Médico
            $usuario = Auth::user();
            $medico = $usuario->medico;

            // Mês selecionado (ou mês atual por padrão)
            $mesSelecionado = $request->get('mes', now()->month);

            // Consultas de hoje (status a)
            $consultasHoje = Consulta::whereHas('agenda', function($q) use ($medico) {
                    $q->where('medico_id', $medico->id);
                })
                ->whereDate('data', now()->format('Y-m-d'))
                ->where('status', 'reservada')
                ->count();

            // Pacientes únicos atendidos no mês
            $pacientesMes = Consulta::whereHas('agenda', function($q) use ($medico) {
                    $q->where('medico_id', $medico->id);
                })
                ->whereMonth('data', $mesSelecionado)
                ->where('status', 'realizada')
                ->whereNotNull('paciente_id')
                ->distinct('paciente_id')
                ->count('paciente_id');

            // Consultas realizadas no mês
            $consultasMes = Consulta::whereHas('agenda', function($q) use ($medico) {
                    $q->where('medico_id', $medico->id);
                })
                ->whereMonth('data', $mesSelecionado)
                ->where('status', 'realizada')
                ->count();

            // Cancelamentos no mês
            $cancelamentosMes = Consulta::whereHas('agenda', function($q) use ($medico) {
                    $q->where('medico_id', $medico->id);
                })
                ->whereMonth('data', $mesSelecionado)
                ->where('status', 'cancelada')
                ->count();

            // Próximas 5 consultas
            $proximasConsultas = Consulta::whereHas('agenda', function($q) use ($medico) {
                    $q->where('medico_id', $medico->id);
                })
                ->where('data', '>=', now()->format('Y-m-d'))
                ->whereIn('status', ['disponivel', 'reservada', 'cancelada'])
                ->orderBy('data')
                ->orderBy('hora_inicio')
                ->with(['paciente.usuario'])
                ->take(5)
                ->get();

            // Gráfico de consultas realizadas por dia do mês selecionado
            $dadosMensais = Consulta::select(
                    DB::raw('DAY(data) as dia'),
                    DB::raw('COUNT(*) as total')
                )
                ->whereHas('agenda', function($q) use ($medico) {
                    $q->where('medico_id', $medico->id);
                })
                ->whereMonth('data', $mesSelecionado)
                ->where('status', 'realizada')
                ->groupBy('dia')
                ->orderBy('dia')
                ->pluck('total', 'dia');
            
            // Consultas realizadas por mês
            $consultasPorMes = Consulta::select(
                DB::raw('MONTH(data) as mes'),
                DB::raw('COUNT(*) as total')
            )
                ->whereHas('agenda', function ($query) use ($medico) {
                    $query->where('medico_id', $medico->id);
                })
                ->where('status', 'realizada')
                ->groupBy('mes')
                ->orderBy('mes')
                ->get();

            // Tradução dos meses
            $nomesMeses = [
                1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
                5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
                9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
            ];

            // Formata os dados do gráfico
            $dadosGrafico = [];
            foreach ($consultasPorMes as $item) {
                $dadosGrafico[] = [
                    'mes' => $nomesMeses[$item->mes],
                    'total' => $item->total
                ];
            }

            // Verifica se há consultas realizadas
            $temConsultas = count($dadosGrafico) > 0;

            $labels = $dadosMensais->keys();
            $dados = $dadosMensais->values();
            
            $notificacoes = Notificacao::where('usuario_id', Auth::id())
                ->orderByDesc('created_at')
                ->take(10)
                ->get();

            return view('dashboardMedico', compact('consultasHoje','pacientesMes','consultasMes',
                'cancelamentosMes','proximasConsultas','labels','dados','notificacoes',
                'mesSelecionado','dadosGrafico', 'temConsultas'
            ));
        } 
        else { // Administrador
            return view('dashboardAdmin');
        }
    }
}
