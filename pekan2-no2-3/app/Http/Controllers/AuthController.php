<?php

namespace App\Http\Controllers;

use App\Support\DemoData;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register', [
            'sekolahList' => DemoData::sekolah(),
            'siswaList' => DemoData::siswa(),
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'role' => ['required', 'in:guru,orang_tua,dinas'],
        ]);

        $user = collect(DemoData::users())->first(function ($u) use ($credentials) {
            return $u['email'] === $credentials['email']
                && $u['password'] === $credentials['password']
                && $u['role'] === $credentials['role'];
        });

        if (! $user) {
            return back()
                ->withInput($request->only('email', 'role'))
                ->withErrors(['email' => 'Login gagal, periksa email, password, dan role yang dipilih.']);
        }

        $request->session()->put('auth_user', [
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
            ...$user['extra'],
        ]);

        $path = $user['role'] === 'orang_tua'
            ? '/orangtua/dashboard'
            : '/'.$user['role'].'/dashboard';

        return redirect()->to($path);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'role' => ['required', 'in:guru,orang_tua,dinas'],
            'nama_lengkap' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6'],
            'nomor_hp' => ['nullable', 'string', 'max:20'],
        ]);

        return redirect()
            ->route('login')
            ->with('registered', 'Registrasi berhasil! Akun demo sudah tersedia, silakan masuk dengan kredensial demo.');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('auth_user');

        return redirect()->route('login');
    }
}
