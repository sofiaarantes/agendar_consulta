<?php

namespace App\Http\Controllers;

use App\Models\Notificacao;
use Illuminate\Support\Facades\Auth;

class NotificacaoController extends Controller
{
    public function destroy($id)
    {
        $notificacao = Notificacao::findOrFail($id);

        // Garante que a notificação pertence ao usuário logado
        if ($notificacao->usuario_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Você não tem permissão para marcar esta notificação.');
        }

        $notificacao->delete();

        return redirect()->back()->with('success', 'Notificação marcada como lida.');
    }
}
