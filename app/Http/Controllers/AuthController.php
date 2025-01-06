<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\PasswordResetToken;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;


class AuthController extends Controller
{
    public function showRegisterForm()
    {
        $title = "Register";
        return view('auth.register', compact('title'));
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        try {
            // Enkripsi password
            $validatedData['password'] = Hash::make($validatedData['password']);
            
            // Buat pengguna baru
            User::create($validatedData);
    
            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Berhasil daftar akun, silakan login.');
    
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, kembalikan dengan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mendaftar akun. Silakan coba lagi.')->withInput();
        }
    }

    public function userLoginForm()
    {
        $title = "Login";
        return view('auth.user-login', compact('title'));
    }

    public function userLogin(Request $request)
    {
        // Validasi input pengguna
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $role = Auth::user()->role;

            if ($role != 'admin') {
                return redirect()->back()->with('successLogin', 'Login berhasil, Anda akan diarahkan ke dashboard.');
            } else {
                Auth::logout();
                return back()->with('loginError', 'Login failed!')->withInput();
            }
        }

        // Jika kredensial salah, redirect kembali dengan error message
        return back()->with('loginError', 'Email atau password salah')->withInput();
    }

    public function adminLoginForm()
    {
        return view('auth.admin-login');
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $role = Auth::user()->role;
            if ($role == 'admin' || $role == 'superadmin') {
                return redirect()->intended('admin/dashboard');
            } else {
                return back()->with('error', 'Login gagal!');
            }
        }

        return back()->with('error', 'Login gagal!')->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function showForgotPasswordForm()
    {
        $title = 'Lupa Password';

        return view('auth.forgot-password', compact('title'));
    }

    public function sendResetLink(Request $request)
    {
        $customMessage = [
            'email.required'    => 'Email tidak boleh kosong',
            'email.email'       => 'Email tidak valid',
            'email.exists'      => 'Email tidak terdaftar di database',
        ];

        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], $customMessage);

        $token = \Str::random(60);

        PasswordResetToken::updateOrCreate(
            [
                'email' => $request->email
            ],
            [
                'email' => $request->email,
                'token' => $token,
                'created_at' => now(),
            ]
        );

        Mail::to($request->email)->send(new ResetPasswordMail($token));

        return redirect()->route('forgot.password')->with('success', 'Kami telah mengirimkan link reset password ke email Anda, silakan buka inbox email anda.');
    }

    public function showResetPasswordForm(Request $request, $token)
    {
        $title = 'Reset Password';
        $getToken = PasswordResetToken::where('token', $token)->first();
        
        if (!$getToken) {
            return redirect()->route('user.login')->with('failed', 'Token tidak valid');
        }

        return view('auth.validasi-token', compact('token', 'title'));
    }

    public function resetPassword(Request $request)
    {
        
        $customMessage = [
            'password.required' => 'Password tidak boleh kosong',
            'password.min'      => 'Password minimal 6 karakter',
        ];
        
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ], $customMessage);
        
        $token = PasswordResetToken::where('token', $request->token)->first();
        
        if (!$token) {
            return redirect()->route('user.login')->with('failed', 'Token tidak valid');
        }
        
        $user = User::where('email', $token->email)->first();
        
        if (!$user) {
            return redirect()->route('user.login')->with('failed', 'Email tidak terdaftar di database');
        }

        // Pastikan update langsung pada objek user yang ditemukan
        $user->password = Hash::make($request->password);
        $user->save();
        
        $token->delete();
        
        return redirect()->route('user.login')->with('success', 'Password berhasil direset');
    }
}