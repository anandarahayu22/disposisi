<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginApiController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // $cekpass = Hash::check($request->password, $user->password);
        // dd($cekpass, $request->password, $user->password, $request->all());

        // dd(Hash::check($request->password, $user->password));
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'error' => 'Invalid credentials'
            ], 401);
        }

        // Generate token (misal pakai JWT atau token lain)
        $token = bin2hex(random_bytes(40));  // Contoh token manual

        // Simpan token ke database (misal pada kolom `token`)
        $user->token = $token;
        $user->save();

        // Kirim respons dengan token dan informasi user
        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    // Logout API
    public function logout(Request $request)
    {
        $user = User::where('token', $request->token)->first();

        if (!$user) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        // Hapus token
        $user->token = null;
        $user->save();

        return response()->json(['message' => 'Logout successful'], 200);
    }
}
