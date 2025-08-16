<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;

class OTPLogicController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function forgotPassword()
    {
        return view('auth.forgotPassword');
    }

    public function sendOtp(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        try {
            $this->authService->sendOtp($validated['email']);
            return redirect()->route('password.reset.form')->with('success', 'OTP sent successfully to your email.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to send OTP. Please try again.');
        }
    }

    public function showResetForm()
    {
        return view('auth.reset_password');
    }

    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'email'    => 'required|email|exists:users,email',
            'otp'      => 'required|string|size:6',
            'password' => 'required|confirmed|min:6',
        ]);

        try {
            $this->authService->resetPassword($validated);
            return redirect()->route('Auth.login')->with('success', 'Password reset successfully. Please log in.');
        } catch (\Exception $e) {
            return back()->with('error', 'Invalid or expired OTP.');
        }
    }
}
