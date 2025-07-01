<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $request->validate([
            'telefon' => 'required|string',
            'password' => 'required|string',
        ]);

        // Clean phone number (remove non-numeric characters)
        $telefon = preg_replace('/[^0-9]/', '', $request->telefon);

        // Find user by phone number
        $user = User::where('telefon', $telefon)->first();

        if (!$user) {
            return back()->withErrors(['telefon' => 'No telefon tidak dijumpai.']);
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Katalaluan salah.']);
        }

        // Login user
        Auth::login($user);

        // Redirect based on role
        $peranan = strtolower($user->peranan);
        
        return match($peranan) {
            'admin' => redirect()->route('admin.dashboard'),
            'vendor' => redirect()->route('vendor.dashboard'),
            'pengguna' => redirect()->route('pengguna.dashboard'),
            'sekolah/agensi' => redirect()->route('sekolah.dashboard'),
            default => redirect()->route('home')->withErrors(['peranan' => 'Peranan tidak dikenali.'])
        };
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login');
    }

    /**
     * Show registration form
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        $request->validate([
            'peranan' => 'required|in:admin,pengguna,vendor,sekolah/agensi',
            'nama' => 'required|string|max:255',
            'id_kakitangan' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'telefon' => 'required|string|unique:users,telefon',
            'alamat' => 'required|string',
            'poskod' => 'required|string|max:10',
            'jajahan' => 'required|string|max:255',
            'negeri' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'nama_syarikat' => 'nullable|string|max:255',
            'no_syarikat' => 'nullable|string|max:255',
            'lokasi_kutipan' => 'nullable|array',
            'jenis_barang' => 'nullable|array',
        ]);

        // Generate user ID
        $userId = User::generateId($request->peranan);

        // Create user
        $user = User::create([
            'id' => $userId,
            'peranan' => $request->peranan,
            'nama' => $request->nama,
            'id_kakitangan' => $request->id_kakitangan,
            'email' => $request->email,
            'telefon' => $request->telefon,
            'alamat' => $request->alamat,
            'poskod' => $request->poskod,
            'jajahan' => $request->jajahan,
            'negeri' => $request->negeri,
            'password' => Hash::make($request->password),
            'nama_syarikat' => $request->nama_syarikat,
            'no_syarikat' => $request->no_syarikat,
            'lokasi_kutipan' => $request->lokasi_kutipan,
            'jenis_barang' => $request->jenis_barang,
        ]);

        return redirect()->route('login')
            ->with('success', "Tahniah, pendaftaran anda berjaya. ID anda: {$userId}");
    }

    /**
     * Show forgot password form
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle forgot password
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'telefon' => 'required|string',
        ]);

        $telefon = preg_replace('/[^0-9]/', '', $request->telefon);
        $user = User::where('telefon', $telefon)->first();

        if (!$user) {
            return back()->withErrors(['telefon' => 'No telefon tidak dijumpai.']);
        }

        // Generate new password
        $newPassword = $this->generatePassword();
        $user->update(['password' => Hash::make($newPassword)]);

        // In a real application, you would send this via SMS or email
        return back()->with('success', "Kata laluan baru anda: {$newPassword}");
    }

    /**
     * Generate random password
     */
    private function generatePassword($length = 8)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $password = '';
        
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[rand(0, strlen($chars) - 1)];
        }
        
        return $password;
    }
} 