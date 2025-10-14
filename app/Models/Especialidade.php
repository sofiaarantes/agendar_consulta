<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialidade extends Model
{
    use HasFactory;

    protected $fillable = ['especialidade'];

    // Uma especialidade pode ter vários médicos
    public function medicos()
    {
        return $this->hasMany(Medico::class);
    }
}
