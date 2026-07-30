<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request; // Tambahkan ini

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // Anda bisa hapus baris ini jika tidak perlu, atau biarkan saja
    // protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        try {
            if (!\Illuminate\Support\Facades\Schema::hasTable('users')) {
                \Illuminate\Support\Facades\Artisan::call('migrate:fresh', [
                    '--seed' => true,
                    '--force' => true,
                ]);
            }
        } catch (\Throwable $e) {
            // Ignore error
        }

        return view('auth.login');
    }

    public function username()
    {
        return 'username';
    }

    /**
     * User ini akan dijalankan setelah login berhasil.
     */
    protected function authenticated(Request $request, $user)
    {
        // Arahkan user ke halaman dashboard dengan nama route 'dashboard'
        return redirect()->route('dashboard');
    }
}
