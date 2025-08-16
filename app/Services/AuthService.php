<?php

namespace App\Services;

use App\Models\OTP;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Handle user registration
     */
    public function register(array $data): User
    {
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'address'  => $data['address'] ?? null,
        ]);


        Auth::login($user);
        $user->session_id = Session::getId();
        $user->save();

        return $user;
    }

    /**
     * Handle user login
     */
    public function login(array $data)
    {
        if (Auth::attempt($data)) {
            $user = Auth::user();

            if ($user->session_id && $user->session_id !== Session::getId()) {
                Session::getHandler()->destroy($user->session_id);
            }

            session()->regenerate();


            $user->session_id = Session::getId();
            $user->save();

            return $user;
        }

        return null;
    }

    /**
     * Handle user logout
     */
    public function logout(): void
    {
        $user = Auth::user();
        if ($user) {
            $user->session_id = null;
            $user->save();
        }

        Auth::logout();
        Session::invalidate();
        Session::regenerateToken();
    }

    /**
     * Generate random OTP
     */
    private function generateOtp(int $length = 6): string
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $otp = '';
        for ($i = 0; $i < $length; $i++) {
            $otp .= $characters[random_int(0, strlen($characters) - 1)];
        }
        return $otp;
    }

    /**
     * Send OTP to user email
     */
    public function sendOtp(string $email): void
    {
        $user = User::where('email', $email)->firstOrFail();

        $otp = $this->generateOtp(6);

        OTP::updateOrCreate(
            ['email' => $user->email],
            [
                'otp'        => $otp,
                'expires_at' => Carbon::now()->addMinutes(10),
            ]
        );

        Mail::raw("Your login OTP is: $otp", function ($message) use ($user) {
            $message->to($user->email)->subject('Your Login OTP');
        });
    }

    /**
     * Reset password using OTP
     */
    public function resetPassword(array $data): void
    {
        $otpRecord = OTP::where('email', $data['email'])
            ->where('otp', $data['otp'])
            ->where('expires_at', '>=', Carbon::now())
            ->first();

        if (!$otpRecord) {
            throw ValidationException::withMessages([
                'otp' => 'Invalid or expired OTP.',
            ]);
        }

        $user = User::where('email', $data['email'])->firstOrFail();
        $user->update([
            'password' => Hash::make($data['password'])
        ]);

        $otpRecord->delete();
    }
}
