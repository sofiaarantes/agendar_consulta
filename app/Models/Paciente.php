<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $table = 'pacientes';
    public $timestamps = false;

    protected $fillable = [
        'data_nascimento',
        'endereco',
        'usuario_id'
    ];

    // RELACIONAMENTOS
    
    // Cada paciente pertence a um usuário
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Um paciente pode ter várias consultas
    public function consultas()
    {
        return $this->hasMany(Consulta::class, 'paciente_id');
    }
}