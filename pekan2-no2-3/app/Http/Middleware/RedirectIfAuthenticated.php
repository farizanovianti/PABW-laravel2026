<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->session()->get('auth_user');

        if ($user) {
            $path = $user['role'] === 'orang_tua'
                ? '/orangtua/dashboard'
                : '/'.$user['role'].'/dashboard';

            return redirect()->to($path);
        }

        return $next($request);
    }
}
