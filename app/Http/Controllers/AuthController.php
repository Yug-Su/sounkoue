<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin(Request $request)
    {
        if ($request->has('tontine_to_join')) {
            $request->session()->put('tontine_to_join', $request->tontine_to_join);
        }
        return view('auth.login');
    }

    public function showRegister(Request $request)
    {
        if ($request->has('tontine_to_join')) {
            $request->session()->put('tontine_to_join', $request->tontine_to_join);
        }
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            // Vérifier s'il y a une tontine à rejoindre après la connexion
            $tontineId = $request->session()->pull('tontine_to_join') ?? $request->input('tontine_to_join');
            if ($tontineId) {
                $tontine = \App\Models\Tontine::find($tontineId);
                
                if ($tontine) {
                    return redirect()->route('tontines.show', $tontine)
                        ->with('success', 'Connexion réussie ! Vous pouvez maintenant rejoindre cette tontine.');
                }
            }
            
            return redirect()->intended('/dashboard');
        }

        throw ValidationException::withMessages([
            'email' => 'Les informations d\'identification fournies sont incorrectes.',
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        // Vérifier s'il y a une tontine à rejoindre après l'inscription
        $tontineId = $request->session()->pull('tontine_to_join') ?? $request->input('tontine_to_join');
        if ($tontineId) {
            $tontine = \App\Models\Tontine::find($tontineId);
            
            if ($tontine) {
                return redirect()->route('tontines.show', $tontine)
                    ->with('success', 'Compte créé avec succès ! Vous pouvez maintenant rejoindre cette tontine.');
            }
        }

        return redirect('/dashboard')->with('success', 'Compte créé avec succès !');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->to('/')->with('success', 'Déconnexion réussie');
    }

    public function profile()
    {
        return view('auth.profile', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|unique:users,phone,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = $request->only(['name', 'email', 'phone']);
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Profil mis à jour avec succès');
    }
}