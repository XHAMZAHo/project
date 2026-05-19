<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\EmailOtp;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class OtpVerificationController extends Controller
{
    // ── Show OTP form ───────────────────────────────────────────────────────
    public function show(Request $request): View|RedirectResponse
    {
        $userId = $request->session()->get('pending_otp_user_id');

        if (! $userId || ! User::find($userId)) {
            return redirect()->route('register')
                ->withErrors(['email' => __('Session expired. Please register again.')]);
        }

        return view('auth.verify-otp');
    }

    // ── Verify submitted OTP ────────────────────────────────────────────────
    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'otp' => ['required', 'string', 'digits:6'],
        ]);

        $userId = $request->session()->get('pending_otp_user_id');

        if (! $userId) {
            return redirect()->route('register')
                ->withErrors(['email' => __('Session expired. Please register again.')]);
        }

        // ── Rate limiting: max 10 attempts per minute per IP ────────────────
        $rateLimitKey = 'otp-verify:' . $request->ip();

        if (RateLimiter::tooManyAttempts($rateLimitKey, 10)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            return back()->withErrors([
                'otp' => __("Too many attempts. Please wait :seconds seconds.", [
                    'seconds' => $seconds,
                ]),
            ]);
        }

        RateLimiter::hit($rateLimitKey, 60);

        $user = User::find($userId);

        if (! $user) {
            $request->session()->forget('pending_otp_user_id');
            return redirect()->route('register')
                ->withErrors(['email' => __('Account not found. Please register again.')]);
        }

        $otpRecord = EmailOtp::where('user_id', $user->id)->latest()->first();

        // ── Check existence ─────────────────────────────────────────────────
        if (! $otpRecord) {
            return back()->withErrors([
                'otp' => __('No verification code found. Please request a new one.'),
            ]);
        }

        // ── Check if locked (too many attempts) ─────────────────────────────
        if ($otpRecord->isLocked()) {
            return back()->withErrors([
                'otp' => __('Too many incorrect attempts. Please request a new code.'),
            ])->with('show_resend', true);
        }

        // ── Check expiry ────────────────────────────────────────────────────
        if ($otpRecord->isExpired()) {
            return back()->withErrors([
                'otp' => __('Your verification code has expired. Please request a new one.'),
            ])->with('show_resend', true);
        }

        // ── Verify the code ─────────────────────────────────────────────────
        if (! $otpRecord->verify($request->otp)) {
            $otpRecord->incrementAttempts();

            $remaining = EmailOtp::MAX_ATTEMPTS - $otpRecord->fresh()->attempts;

            return back()->withErrors([
                'otp' => __('Invalid verification code. :count attempt(s) remaining.', [
                    'count' => max(0, $remaining),
                ]),
            ]);
        }

        // ── Success ─────────────────────────────────────────────────────────
        // Mark email as verified
        $user->update(['email_verified_at' => now()]);

        // Delete the used OTP
        $otpRecord->delete();

        // Clear rate limiter and session
        RateLimiter::clear($rateLimitKey);
        $request->session()->forget('pending_otp_user_id');

        // Log the user in
        Auth::login($user, remember: true);

        $request->session()->regenerate();

        return redirect()->intended($this->redirectAfterVerification($user))
            ->with('success', __('Email verified successfully! Welcome to ELEVA TECH 🎉'));
    }

    // ── Resend OTP ──────────────────────────────────────────────────────────
    public function resend(Request $request): RedirectResponse
    {
        $userId = $request->session()->get('pending_otp_user_id');

        if (! $userId) {
            return redirect()->route('register')
                ->withErrors(['email' => __('Session expired. Please register again.')]);
        }

        // ── Rate limiting: max 3 resends per 5 minutes per IP ───────────────
        $rateLimitKey = 'otp-resend:' . $request->ip();

        if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            return back()->withErrors([
                'otp' => __("Too many resend requests. Please wait :seconds seconds.", [
                    'seconds' => $seconds,
                ]),
            ]);
        }

        $user = User::find($userId);

        if (! $user) {
            $request->session()->forget('pending_otp_user_id');
            return redirect()->route('register');
        }

        // Generate a fresh OTP
        ['plain' => $plain] = EmailOtp::generateFor($user);

        // Send email
        Mail::to($user->email)->send(new OtpMail($user, $plain));

        RateLimiter::hit($rateLimitKey, 300); // 5 min window

        return back()->with('resent', __('A new verification code has been sent to your email.'));
    }

    // ── Private helpers ─────────────────────────────────────────────────────
    private function redirectAfterVerification(User $user): string
    {
        if ($user->isAdmin() || $user->isStaff()) {
            return route('admin.dashboard');
        }
        return route('client.dashboard');
    }
}
