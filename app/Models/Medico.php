<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    use HasFactory;

    protected $table = 'medicos';
    public $timestamps = false;

    protected $fillable = [
        'status',
        'crm',
        'clinica',
        'especialidade_id',
        'usuario_id'
    ];

    // RELACIONAMENTOS
    
    // Cada médico pertence a um usuário
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Um médico pode ter vários horários na agenda
    public function agendas()
    {
        return $this->hasMany(AgendaMedica::class, 'medico_id');
    }

    // Um médico pode ter várias consultas
    public function consultas()
    {
        return $this->hasMany(Consulta::class, 'medico_id');
    }

    // Um médico pertence a uma especialidade
    public function especialidade()
    {
        return $this->belongsTo(Especialidade::class, 'especialidade_id');
    }
}