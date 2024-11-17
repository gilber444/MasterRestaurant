<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('user', 'password');

        // Intentar autenticación con el campo 'user' o 'email'
        if (Auth::attempt(['user' => $credentials['user'], 'password' => $credentials['password']]) ||
            Auth::attempt(['email' => $credentials['user'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();

           // Verificar el perfil del usuario autenticado
           $user = Auth::user();

           if ($user->status !== 'ACTIVE') {
                Auth::logout(); // Desconectar si la cuenta no está activa
                return back()->withErrors(['user' => 'Tu cuenta está inactiva. Contacta al administrador.']);
            }

           if ($user->profile !== 'Cajeros') {
               // Si el perfil no es "cajero", redirigir a la ruta del dashboard
               return redirect()->intended(route('dashboard'));
           } else {
               // Si el perfil es "cajero", redirigir a la ruta de actividades
               return redirect()->intended(route('actividades'));
           }
        }

        return back()->withErrors([
            'user' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
