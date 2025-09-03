<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(UserRequest $request)
    {
        $user = $this->authService->register($request->validated());

        return redirect()->route('home')->with('success', 'User registered successfully');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = $this->authService->login($credentials);

        if (! $user) {
            return back()->withErrors([
                'email' => 'Invalid email or password',
            ])->withInput();
        }

        return $user->role === "customer"
            ? redirect()->route("home")->with('success', 'Logged in successfully')
            : redirect()->route("AdminDashboard");
    }

    public function logout(Request $request)
    {
        $this->authService->logout();

        return redirect('/login')->with('success', 'Logged out successfully');
    }
}
