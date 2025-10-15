<?php

namespace App\Http\Controllers;

use App\Models\Especialidade;
use App\Models\Medico;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function edit($id)
    {
        $admin = User::findOrFail($id);
        return view('admins/edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'telefone' => 'required|string|max:255',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $admin->name = $request->nome;
        $admin->email = $request->email;
        $admin->telefone = $request->telefone;

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profiles', 'public');
            $admin->profile_photo_path = $path;
        }

        $admin->save();

        return redirect()->route('users.edit', $admin->id)
                        ->with('success', 'Perfil atualizado com sucesso!');
    }
}