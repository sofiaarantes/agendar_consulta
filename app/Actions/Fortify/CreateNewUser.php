<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'tipo_usuario' => ['required', 'integer', 'in:1,2,3'], // paciente, medico, admin
            'telefone' => ['required', 'integer'], 
            'profile_photo' => ['nullable', 'image', 'max:2048'], 
        ])->validate();

        $photoPath = null;

        if (request()->hasFile('profile_photo')) {
            $photoPath = request()->file('profile_photo')->store('profile-photos', 'public');
        }
        
        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'tipo_usuario' =>  $input['tipo_usuario'],
            'telefone' =>  $input['telefone'],
            'profile_photo_path' => $photoPath, // <--- aqui
        ]);
    }
}
