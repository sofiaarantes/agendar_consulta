<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'tipo_usuario',
        'telefone',
        'profile_photo_path',
    ];

    // RELACIONAMENTOS
    
    // Um usuário pode ter um perfil de paciente
    public function paciente()
    {
        return $this->hasOne(Paciente::class, 'usuario_id');
    }

    // Um usuário pode ter um perfil de médico
    public function medico()
    {
        return $this->hasOne(Medico::class, 'usuario_id');
    }

    // Um usuário pode receber várias notificações
    public function notificacoes()
    {
        return $this->hasMany(Notificacao::class, 'usuario_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
