<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if ($user && $user->is_banned) {
            throw ValidationException::withMessages([
                'email' => 'This account has been suspended for security policy violations.',
            ]);
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            Auth::user()->update(['last_active_at' => now()]);

            AuditService::log('user_login', 'info', 'User', Auth::id(), [
                'email' => Auth::user()->email,
            ]);

            return redirect()->intended(route('dashboard'))
                ->with('success', 'Welcome back, ' . Auth::user()->name . '!');
        }

        throw ValidationException::withMessages([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('pages.auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'player',
            'xp' => 100,
            'level' => 1,
            'streak' => 1,
            'coins' => 100,
            'last_active_at' => now(),
        ]);

        Auth::login($user);

        AuditService::log('user_registered', 'info', 'User', $user->id, [
            'name' => $user->name,
            'email' => $user->email,
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Your QuizVerse account has been successfully initialized! +100 Starter XP awarded.');
    }

    public function quickLogin(string $role)
    {
        $email = match ($role) {
            'admin' => 'admin@quizverse.com',
            'creator' => 'creator@quizverse.com',
            default => 'player@quizverse.com',
        };

        $user = User::where('email', $email)->first();
        if ($user) {
            Auth::login($user);
            request()->session()->regenerate();
            return redirect()->route('dashboard')
                ->with('success', "Quick-switched to {$user->name} ({$user->role}) session.");
        }

        return redirect()->route('login');
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            AuditService::log('user_logout', 'info', 'User', Auth::id());
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('info', 'You have been safely disconnected from your QuizVerse session.');
    }
}
