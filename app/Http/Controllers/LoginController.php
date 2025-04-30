<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request): RedirectResponse
{
    $credentials = $request->validate([
        'nik' => ['required'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        $user = Auth::user();

        // ✨ Tambahan: cek apakah akun sudah diaktifkan
        if (!$user->is_active) {
            Auth::logout();
            return back()->withErrors([
                'nik' => 'Akun Anda belum diaktifkan oleh Admin.',
            ])->onlyInput('nik');
        }

        // Cek role user
        if ($user->role === 'admin') {
            return redirect()->intended('/admin/dashboard');
        } elseif ($user->role === 'user') {
            return redirect()->intended('/user/berita');
        } else {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Akun tidak memiliki role yang valid.',
            ]);
        }
    }

    return back()->withErrors([
        'nik' => 'NIK atau password salah.',
    ])->onlyInput('nik');

}


public function logout(Request $request): RedirectResponse
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->intended('');
}


    public function index(){
        return view('login');
    }

    public function halamanutama(){
        return view('index');
    }

    public function register(){
        return view('register');
    }

    public function registersuccess(Request $request)
    {
        $request->validate([
            'nik' => 'required|digits:16|unique:users,nik',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|digits_between:10,13',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'ktp' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'kk' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Upload file
        $ktpPath = $request->file('ktp')->store('ktp', 'public');
        $kkPath = $request->file('kk')->store('kk', 'public');

        // Simpan user
        User::create([
            'nik' => $request->nik,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'ktp' => $ktpPath,
            'kk' => $kkPath,
            'password' => Hash::make($request->password),
            'role' => 'user', // default user
            'is_active' => false, // ini penting
        ]);


        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silahkan login.');
    }

    public function activate($id)
{
    $user = User::findOrFail($id);
    $user->is_active = 1;
    $user->save();

    return redirect()->route('admin.akun')->with('success', 'Akun berhasil diaktifkan.');
}
}


