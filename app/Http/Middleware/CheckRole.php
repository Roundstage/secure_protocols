<?php

namespace App\Http\Middleware;

use App\Enums\RolesEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        $userRole = auth()->user()->role()->get();
        if (!$userRole->contains('level', $role)) {
            // Usuário não tem a role necessária
            return redirect('/login'); // Redirecione para a página desejada
        }

        return $next($request);
    }
}
