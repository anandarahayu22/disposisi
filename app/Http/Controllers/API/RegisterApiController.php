<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class RegisterApiController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'unique:users', 'alpha_num', 'min:3', 'max:25'],
            'name' => ['required', 'string', 'min:3'],
            'email' => ['required', 'unique:users', 'email'],
            'password' => ['required', 'min:8'],
            'phone' => ['nullable', 'string', 'max:15'],  // Validasi untuk phone
            'address' => ['nullable', 'string', 'max:255'], // Validasi untuk address
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Gunakan Hash untuk meng-hash password
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'name' => $request->name,
            'password' => Hash::make($request->password), // Hash password
            'phone' => $request->phone, // Simpan phone
            'address' => $request->address, // Simpan address
        ]);
        // dd($request->all(), $user);

        $token = $user->createToken('API Token')->plainTextToken;
        $user->token = $token;
        $user->save();

        return response()->json([
            'message' => 'Registrasi berhasil.',
            'token' => $token,
            'user' => $user
        ], 201);
    }
}
