<?php

use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\AgendaMedicaController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EspecialidadeController;
use App\Http\Controllers\NotificacaoController;
use App\Http\Controllers\UserController;
use App\Models\Medico;
use Illuminate\Support\Facades\Route;

// Rota inicial;
Route::get('/', function () {
    return view('auth/login');
})->name('raiz');

// Rota de registro de usuário
Route::get('registerUser', function () {
    return view('auth/registerUser');
})->name('registerUser');

// Rotas para a conclusão de registro, se o usário for médico
Route::get('/medicos/create', [MedicoController::class, 'create'])->name('medicos.create');
Route::post('/medicos', [MedicoController::class, 'store'])->name('medicos.store');

Route::middleware(['auth'])->group(function() {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rotas para Pacientes
    Route::get('/pacientes/buscar', [PacienteController::class, 'buscar'])->name('pacientes.buscar');
    Route::resource('pacientes', PacienteController::class);

    // Rotas para Médicos
    Route::resource('medicos', MedicoController::class);

    // Rotas para Agenda Médica
    Route::resource('agendas', AgendaMedicaController::class);

    // Rotas para editar admins
    Route::resource('users', UserController::class);

    // Rotas para Consultas
    Route::post('/consultas/marcar', [ConsultaController::class, 'marcar'])->name('consultas.marcar');
    Route::put('/consultas/{id}/cancelar', [ConsultaController::class, 'cancelar'])->name('consultas.cancelar');
    Route::get('/consultas/historico', [ConsultaController::class, 'historico'])->name('consultas.historico');
    Route::post('/consultas/{id}/realizar', [ConsultaController::class, 'marcarComoRealizada'])->name('consultas.realizar');
    Route::get('/consultas/{id}/cancelarform', [ConsultaController::class, 'formCancelar'])->name('consultas.cancelar.form');
    Route::resource('consultas', ConsultaController::class);

    // Rotas para Especialidades
    Route::resource('especialidades', EspecialidadeController::class);

    // Rotas para Notificacoes
    Route::resource('notificacoes', NotificacaoController::class);

    // Rotas adicionais específicas
    Route::get('/autenticar', [MedicoController::class, 'autenticarMedico'])->name('medicos.autenticar');
    Route::post('/medicos/aprovar', [MedicoController::class, 'aprovar'])->name('medicos.aprovar');

    Route::get('/agendas/{codigo_agenda}', [AgendaMedicaController::class, 'show'])->name('agendas.show');

});
