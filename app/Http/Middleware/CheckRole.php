<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Verifica se o usuário possui um dos níveis permitidos.
     */
    public function handle(
        Request $request,
        Closure $next,
        ...$roles
    ): Response {

        // Usuário não autenticado
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Administrador possui acesso total
        if (auth()->user()->isAdmin()) {
            return $next($request);
        }

        // Verifica se o nível do usuário está autorizado
        if (!in_array(auth()->user()->role, $roles, true)) {
            abort(403, 'Você não possui permissão para acessar esta área.');
        }

        return $next($request);
    }
}
