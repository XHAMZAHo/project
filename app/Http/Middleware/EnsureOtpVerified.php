<?php

namespace App\Http\Middleware;

use App\Models\EmailOtp;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * EnsureOtpVerified
 *
 * Blocks authenticated users who have not yet verified their email via OTP.
 * Redirects them to the OTP verification page where they can enter their code.
 */
class EnsureOtpVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        // If not logged in, let auth middleware handle it
        if (! auth()->check()) {
            return $next($request);
        }

        /** @var User $user */
        $user = auth()->user();

        // If already OTP-verified (email_verified_at is set), proceed normally
        if ($user->email_verified_at !== null) {
            return $next($request);
        }

        // User is logged in but NOT verified:
        // Log them out and redirect to OTP page (with their ID in session)
        $userId = $user->id;
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Restore the pending OTP session so they can verify
        $request->session()->put('pending_otp_user_id', $userId);

        // Make sure an active OTP exists; if not, create and email one
        if (! EmailOtp::activeFor($userId)) {
            $freshUser = User::find($userId);
            if ($freshUser) {
                ['plain' => $plain] = EmailOtp::generateFor($freshUser);
                \Illuminate\Support\Facades\Mail::to($freshUser->email)
                    ->send(new \App\Mail\OtpMail($freshUser, $plain));
            }
        }

        return redirect()->route('otp.show')
            ->with('info', __('Please verify your email to continue.'));
    }
}
