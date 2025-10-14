<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;

    protected $fillable = [
        'agenda_id',
        'paciente_id',
        'data',
        'hora_inicio',
        'hora_fim',
        'status',
        'observacao',
    ];

    public function agenda()
    {
        return $this->belongsTo(AgendaMedica::class, 'agenda_id');
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}
