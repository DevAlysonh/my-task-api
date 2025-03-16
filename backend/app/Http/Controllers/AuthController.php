<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Credenciais Inválidas'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();
        $expiresAt = now()->addMinutes(60);
        $token = $user->createToken('task-api-token', ['*'] , $expiresAt)->plainTextToken;

        return response()->json([
            'token' => $token,
            'expires_at' => $expiresAt,
        ]);
    }

    public function destroy(Request $request)
    {
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });
    
        return response()->json(['message' => 'Logout realizado com sucesso']);
    }
}
