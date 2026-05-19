<?php

use App\Http\Controllers\Api\V1\ClientApiController;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ── Chatbot Service Request (public, no auth needed) ──
Route::post('/chatbot-request', function (Request $request) {
    $validated = $request->validate([
        'name'         => 'required|string|max:150',
        'email'        => 'required|email|max:200',
        'service_type' => 'required|string|max:200',
        'budget'       => 'nullable|string|max:100',
        'message'      => 'nullable|string|max:3000',
        'source'       => 'nullable|string|max:50',
    ]);

    try {
        ServiceRequest::create([
            'name'         => $validated['name'],
            'email'        => $validated['email'],
            'service_type' => $validated['service_type'],
            'budget'       => $validated['budget'] ?? null,
            'description'  => ($validated['message'] ?? '') . "\n\n[Source: " . ($validated['source'] ?? 'chatbot') . "]",
            'status'       => 'pending',
        ]);

        return response()->json(['success' => true, 'message' => 'Request received']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
});

Route::post('/v1/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = \App\Models\User::where('email', $request->email)->first();

    if (! $user || ! \Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    return response()->json([
        'token' => $user->createToken('mobile-app')->plainTextToken,
        'user' => $user
    ]);
});

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    });

    Route::get('/me', [ClientApiController::class, 'me']);
    Route::get('/projects', [ClientApiController::class, 'projects']);
    Route::get('/invoices', [ClientApiController::class, 'invoices']);
});
