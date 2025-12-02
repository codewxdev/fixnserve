<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordCodeMail;
use App\Models\PasswordResetCode;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PasswordResetCodeController extends Controller
{
    // STEP 1 — Send OTP
    public function sendResetCode(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        // Delete old codes
        PasswordResetCode::where('email', $request->email)->delete();

        $code = rand(100000, 999999);

        PasswordResetCode::create([
            'email' => $request->email,
            'code' => $code,
            'expires_at' => Carbon::now()->addMinutes(10),
        ]);
        // send otp email
        Mail::to($request->email)->send(new ResetPasswordCodeMail($code));

        return response()->json([
            'status' => true,
            'message' => 'Reset code sent to your email',
        ]);
    }

    // STEP 2 — Verify OTP
    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'code' => 'required',
        ]);

        $record = PasswordResetCode::where('email', $request->email)
            ->where('code', $request->code)
            ->where('is_used', false)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (! $record) {
            return response()->json(['status' => false, 'message' => 'Invalid or expired code'], 422);
        }

        return response()->json(['status' => true, 'message' => 'Code verified']);
    }

    // STEP 3 — Reset Password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'code' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $record = PasswordResetCode::where('email', $request->email)
            ->where('code', $request->code)
            ->where('is_used', false)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (! $record) {
            return response()->json(['status' => false, 'message' => 'Invalid or expired code'], 422);
        }

        $user = User::where('email', $request->email)->first();

        $user->update(['password' => Hash::make($request->password)]);

        $record->update(['is_used' => true]);

        // Login user using JWT
        $token = auth('api')->login($user);

        return response()->json([
            'status' => true,
            'message' => 'Password reset successful',
            'token' => $token,
        ]);
    }
}
