<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required', 'unique:users', 'alpha_num', 'min:3', 'max:25'],
            'name' => ['required', 'string', 'min:3'],
            'email' => ['required', 'unique:users', 'email'],
            'password' => ['required', 'min:8'],
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ]);

        session()->flash('success', 'Terimakasih, kamu berhasil Register.');
        return redirect('/');
    }
}
