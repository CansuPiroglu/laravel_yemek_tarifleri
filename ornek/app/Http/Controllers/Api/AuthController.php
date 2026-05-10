<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * KAYIT OL
     *
     * POST /api/register
     * Body: { name, email, password, password_confirmation }
     */
    public function register(Request $request)
    {
        // 1. Gelen veriyi doğrula
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // 2. Kullanıcıyı kaydet (Şifreyi Hash'leyerek güvenli hale getiriyoruz)
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // 3. Sanctum token üret
        $token = $user->createToken('auth_token')->plainTextToken;

        // 4. Başarılı JSON cevabı dön (201 Created)
        return response()->json([
            'token' => $token,
            'user' => $user
        ], 201);
    }

    /**
     * GİRİŞ YAP
     *
     * POST /api/login
     * Body: { email, password }
     */
    public function login(Request $request)
    {
        // 1. Gelen veriyi doğrula
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // 2. Kullanıcı bilgilerini kontrol et (Auth::attempt)
        if (!Auth::attempt($request->only('email', 'password'))) {
            // Eşleşme yoksa 401 hatası dön
            return response()->json([
                'message' => 'Bu bilgiler sistemimizde kayıtlı değil.'
            ], 401);
        }

        // 3. Eşleşme varsa kullanıcıyı bul
        $user = User::where('email', $request->email)->firstOrFail();

        // 4. Sanctum token üret
        $token = $user->createToken('auth_token')->plainTextToken;

        // 5. Başarılı JSON cevabı dön (200 OK)
        return response()->json([
            'token' => $token,
            'user' => $user
        ], 200);
    }

    /**
     * ME (Mevcut Kullanıcıyı Getir)
     *
     * GET /api/me
     * Header: Authorization: Bearer {token}
     */
    public function me(Request $request)
    {
        // Hocanın dediği gibi çok kısa: İstek yapan doğrulanmış kullanıcıyı JSON olarak dön
        return response()->json($request->user());
    }
}