<?php

namespace App\Http\Controllers;

use App\Models\OTP;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class OTPLogicController extends Controller
{
private function generateOtp($length = 6)
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()';
    $otp = '';
    for ($i = 0; $i < $length; $i++) {
        $otp .= $characters[random_int(0, strlen($characters) - 1)];
    }
    return $otp;
}
public function forgotPassword(){
    return view ('auth.forgotPassword');
}
public function sendOtp(Request $request)
{
    $validated = $request->validate([
        'email' => 'required|email|exists:users,email',
    ]);

    $user = User::where('email', $validated['email'])->first();
    if (!$user) {
        // This will rarely happen since `exists` validation handles it
        return redirect()->back()->with('error', 'No user found with this email.');
    }

    $otp = $otp = $this->generateOtp(6);
    OTP::updateOrCreate(
        ['email' => $user->email],
        [
            'otp' => $otp,
            'expires_at' => Carbon::now()->addMinutes(10),
        ]
    );

    try {
        Mail::raw("Your login OTP is: $otp", function ($message) use ($user) {
            $message->to($user->email)->subject('Your Login OTP');
        });
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to send OTP. Please try again.');
    }

    return redirect()->route('password.reset.form')->with('success', 'OTP sent successfully to your email.');

}

public function showResetForm()
{
    return view('Auth.reset_password');
}

public function resetPassword(Request $request)
{
    $validated = $request->validate([
        'email' => 'required|email|exists:users,email',
        'otp' => 'required|string|size:6',
        'password' => 'required|confirmed|min:6',
    ]);

    $otpRecord = OTP::where('email', $validated['email'])
                    ->where('otp', $validated['otp'])
                    ->where('expires_at', '>=', Carbon::now())
                    ->first();

    if (!$otpRecord) {
        return back()->with('error', 'Invalid or expired OTP.');
    }

    $user = User::where('email', $validated['email'])->first();
    $user->update(['password' => Hash::make($validated['password'])]);

    $otpRecord->delete();

    return redirect()->route('Auth.login')->with('success', 'Password reset successfully. Please log in.');
}
}
