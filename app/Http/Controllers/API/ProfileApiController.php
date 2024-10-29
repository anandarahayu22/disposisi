<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileApiController extends Controller
{
    // Mendapatkan semua profil
    public function index()
    {
        $profiles = User::all(); // Mengambil data dari tabel users
        return response()->json($profiles, 200);
    }

    // Mendapatkan profil berdasarkan user ID
    public function show($userId)
    {
        $user = User::find($userId); // Ambil user berdasarkan ID
        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        return response()->json($user, 200);  // Kembalikan data user yang ditemukan
    }

    // Menambah profil baru
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|min:8',
        ]);

        // Buat user baru
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = bcrypt($request->password); // Hash password
        $user->save();

        return response()->json($user, 201); // Kembalikan data user yang baru dibuat
    }

    // Memperbarui profil berdasarkan user ID
    public function update(Request $request, $userId)
    {
        $user = User::find($userId);  // Ambil user berdasarkan ID
        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,  // Pastikan email unik kecuali email user saat ini
            'password' => 'nullable|min:8',  // Password bersifat opsional
        ]);

        // Perbarui data user
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);  // Hash password baru
        }

        $user->save();  // Simpan perubahan data user

        return response()->json($user, 200);  // Kembalikan data user yang sudah diperbarui
    }

    // Menghapus profil berdasarkan user ID
    public function destroy($userId)
    {
        $user = User::find($userId);  // Ambil user berdasarkan ID
        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        $user->delete();  // Hapus user
        return response()->json(['message' => 'User berhasil dihapus'], 200);
    }
}
