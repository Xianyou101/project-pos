<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Tampilkan halaman register (jika diperlukan)
     */
    public function show()
    {
        return view('auth.register'); // optional jika pakai form sendiri
    }

    /**
     * Proses registrasi user baru
     */
    public function register(Request $request)
    {
        // Validasi input user
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|string|min:6|confirmed',
        ]);

        // Simpan user baru
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Login otomatis setelah daftar
        Auth::login($user);

        // Redirect ke panel admin
        return redirect()->intended('/admin');
    }
}
