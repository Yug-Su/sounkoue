<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AutoRedirectToDashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Liste des routes publiques autorisées
        $publicRoutes = [
            'login', 'register', 'logout', 'password.request', 'password.reset'
        ];
        
        // Si l'utilisateur est connecté et tente d'accéder à la page d'accueil ou aux routes publiques
        if (Auth::check() && 
            ($request->is('/') || 
             $request->routeIs($publicRoutes) || 
             $request->is('login') || 
             $request->is('register'))) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
