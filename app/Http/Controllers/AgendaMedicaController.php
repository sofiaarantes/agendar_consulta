<?php

namespace App\Http\Controllers;

use App\Models\AgendaMedica;
use App\Models\Consulta;
use App\Models\Medico;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendaMedicaController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $medico = $user->medico ?? Medico::where('usuario_id', $user->id)->first();

        $agendas = collect();

        if ($medico) {
            $query = AgendaMedica::where('medico_id', $medico->id)
                ->orderBy('hora_inicio', 'asc');

            if ($request->filled('dia_semana')) {
                $query->whereJsonContains('dias_semana', $request->dia_semana);
            }

            $agendas = $query->get();
        }

        return view('agendas.index', compact('agendas', 'medico'));
    }

    public function create()
    {
        return view('agendas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'medico_id' => 'required|exists:medicos,id',
            'hora_inicio' => 'required',
            'hora_fim' => 'required',
            'duracao_consulta' => 'required|integer|min:10',
            'dias_semana' => 'required|array',
        ]);

        // Cria a agenda
        $agenda = AgendaMedica::create($validated);     

        // Gera os slots de consulta para o próximo mês
        $this->gerarConsultasMensal($agenda, Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth());

        return redirect()->route('agendas.index')->with('success', 'Agenda criada com sucesso e consultas geradas!');
    }

    private function gerarConsultasMensal(AgendaMedica $agenda, Carbon $inicioMes, Carbon $fimMes)
    {
        // Começa a partir de hoje (ou data de criação da agenda), se ainda dentro do mês
        $hoje = Carbon::today();

        // Garante que o início seja o maior entre o começo do mês e hoje
        $dataAtual = $inicioMes->greaterThan($hoje) ? $inicioMes->copy() : $hoje->copy();

        while ($dataAtual->lte($fimMes)) {
            $diaSemana = ucfirst(str_replace('-feira', '', $dataAtual->locale('pt_BR')->dayName));

            // Só gera nos dias ativos
            if (in_array($diaSemana, $agenda->dias_semana)) {
                $horaAtual = Carbon::parse($agenda->hora_inicio);
                $horaFim = Carbon::parse($agenda->hora_fim);

                while ($horaAtual->lt($horaFim)) {
                    $horaInicio = $horaAtual->copy();
                    $horaFimSlot = $horaAtual->copy()->addMinutes((int) $agenda->duracao_consulta);

                    if ($horaFimSlot->gt($horaFim)) break;

                    // Cria o slot de consulta
                    Consulta::create([
                        'agenda_id' => $agenda->id,
                        'data' => $dataAtual->format('Y-m-d'),
                        'hora_inicio' => $horaInicio->format('H:i'),
                        'hora_fim' => $horaFimSlot->format('H:i'),
                        'status' => 'disponivel',
                    ]);

                    $horaAtual = $horaFimSlot;
                }
            }

            $dataAtual->addDay();
        }
    }

    public function show($agenda_id)
    {
        $agenda = AgendaMedica::findOrFail($agenda_id);

        $slots = Consulta::where('agenda_id', $agenda->id)
            ->orderBy('data', 'asc')
            ->orderBy('hora_inicio', 'asc')
            ->get();

        return view('agendas/show', compact('agenda', 'slots'));
    }

    public function edit($id)
    {
        $agenda = AgendaMedica::findOrFail($id);
        return view('agendas/edit', compact('agenda'));
    }

    public function update(Request $request, $id)
    {
        $agenda = AgendaMedica::findOrFail($id);

        $validated = $request->validate([
            'hora_inicio' => 'required',
            'hora_fim' => 'required',
            'duracao_consulta' => 'required|integer|min:10',
            'dias_semana' => 'required|array',
            'observacao' => 'nullable|string',
        ]);

        // Atualiza dados da agenda
        $agenda->update($validated);

        // Atualiza consultas existentes e cria novas se necessário
        $this->atualizarConsultasDisponiveis($agenda);

        return redirect()->route('agendas.index')->with('success', 'Agenda atualizada com sucesso!');
    }

    /**
     * Atualiza consultas disponíveis de acordo com a nova agenda
     */
    private function atualizarConsultasDisponiveis(AgendaMedica $agenda)
    {
        $diasSemana = $agenda->dias_semana;
        $inicioMes = Carbon::now()->startOfMonth();
        $fimMes = Carbon::now()->endOfMonth();
        $dataAtual = $inicioMes->copy();

        while ($dataAtual->lte($fimMes)) {
            $diaAtual = ucfirst(str_replace('-feira', '', $dataAtual->locale('pt_BR')->dayName));

            if (in_array($diaAtual, $diasSemana)) {
                $horaInicioAgenda = Carbon::parse($agenda->hora_inicio);
                $horaFimAgenda = Carbon::parse($agenda->hora_fim);

                $agenda->consultas()
                    ->where('data', $dataAtual->format('Y-m-d'))
                    ->where('status', 'disponivel')
                    ->where(function ($q) use ($horaInicioAgenda, $horaFimAgenda) {
                        $q->where('hora_inicio', '<', $horaInicioAgenda->format('H:i'))
                        ->orWhere('hora_fim', '>', $horaFimAgenda->format('H:i'));
                    })
                    ->delete();

                $horaAtual = $horaInicioAgenda->copy();

                while ($horaAtual->lt($horaFimAgenda)) {
                    $horaFimSlot = $horaAtual->copy()->addMinutes((int) $agenda->duracao_consulta);
                    if ($horaFimSlot->gt($horaFimAgenda)) break;

                    $consultaExistente = $agenda->consultas()
                        ->where('data', $dataAtual->format('Y-m-d'))
                        ->where('hora_inicio', $horaAtual->format('H:i'))
                        ->first();

                    if (!$consultaExistente) {
                        // Cria nova consulta disponível
                        $agenda->consultas()->create([
                            'data' => $dataAtual->format('Y-m-d'),
                            'hora_inicio' => $horaAtual->format('H:i'),
                            'hora_fim' => $horaFimSlot->format('H:i'),
                            'status' => 'disponivel',
                        ]);
                    }

                    $horaAtual = $horaFimSlot;
                }
            } else {
                // Remove consultas disponíveis em dias desativados
                $agenda->consultas()
                    ->where('data', $dataAtual->format('Y-m-d'))
                    ->where('status', 'disponivel')
                    ->delete();
            }

            $dataAtual->addDay();
        }
    }

    public function destroy($id)
    {
        $agenda = AgendaMedica::findOrFail($id);
        $agenda->delete(); // Apaga a agenda e todas as consultas associadas
        return redirect()->route('agendas.index')->with('success', 'Agenda e consultas removidas com sucesso!');
    }

}
