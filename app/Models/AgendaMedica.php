<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaMedica extends Model
{
    use HasFactory;

    protected $table = 'agendas_medicas';

    protected $fillable = [
        'medico_id',
        'hora_inicio',
        'hora_fim',
        'duracao_consulta',
        'dias_semana',
    ];

    protected $casts = [
        'dias_semana' => 'array',
    ];

    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }

    public function consultas()
    {
        return $this->hasMany(Consulta::class, 'agenda_id');
    }
}
