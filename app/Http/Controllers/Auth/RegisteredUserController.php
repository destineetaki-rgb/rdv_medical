<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => 'patient',
            'password' => Hash::make($request->password),
        ]);

        // Créer automatiquement le profil patient
        Patient::create([
            'user_id'        => $user->id,
            'nom'            => $request->name,
            'prenom'         => $request->name,
            'telephone'      => '0000000000',
            'adresse'        => '',
            'date_naissance' => null,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('rendezvous.index');
    }
}