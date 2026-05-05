<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'Username' => ['required', 'string', 'max:255'],
            'Nomer_Telepon' => ['required', 'string', 'max:20'],
            'Email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class.',Email'],
            'Password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'Username' => $request->Username,
            'Nomer_Telepon' => $request->Nomer_Telepon,
            'Email' => $request->Email,
            'Password' => Hash::make($request->Password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('MenuUtama', absolute: false));
    }
}
