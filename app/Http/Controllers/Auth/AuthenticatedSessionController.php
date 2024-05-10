<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return response()->json([
            'token' => $request->session()->token(),
            'status' => 'logged in'
        ], 200);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json([
            'status' => 'logged out'
        ], 200);
    }

    /**
     * List Users.
     */
    public function listUsers(): JsonResponse
    {
        return DB::table('users')
            ->select(['id', 'name', 'email'])
            ->get()
            ->map(function (object $user) {
                return [
                    'id' => (int)$user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ];
            });
    }
}
