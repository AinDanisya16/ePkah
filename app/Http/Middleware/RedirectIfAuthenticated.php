<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();
                $peranan = strtolower($user->peranan);
                
                return match($peranan) {
                    'admin' => redirect()->route('admin.dashboard'),
                    'vendor' => redirect()->route('vendor.dashboard'),
                    'pengguna' => redirect()->route('pengguna.dashboard'),
                    'sekolah/agensi' => redirect()->route('sekolah.dashboard'),
                    default => redirect()->route('home')
                };
            }
        }

        return $next($request);
    }
} 