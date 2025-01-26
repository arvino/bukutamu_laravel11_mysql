<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
	public function showLogin()
	{
		return view('auth.login');
	}

	public function login(Request $request)
	{
		$credentials = $request->validate([
			'email' => ['required', 'email'],
			'password' => ['required'],
		]);

		if (Auth::attempt($credentials, $request->boolean('remember'))) {
			$request->session()->regenerate();
			return redirect()->intended(route('home'))
				->with('success', 'Selamat datang kembali!');
		}

		return back()->withErrors([
			'email' => 'Email atau password salah.',
		])->onlyInput('email');
	}

	public function showRegister()
	{
		return view('auth.register');
	}

	public function register(Request $request)
	{
		$validated = $request->validate([
			'nama' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:members'],
			'phone' => ['required', 'string', 'max:20'],
			'password' => ['required', 'confirmed', Password::defaults()],
		]);

		$member = Member::create([
			'nama' => $validated['nama'],
			'email' => $validated['email'],
			'phone' => $validated['phone'],
			'password' => Hash::make($validated['password']),
			'role' => 'member',
		]);

		event(new Registered($member));
		
		Auth::login($member);

		return redirect()->route('verification.notice')
			->with('success', 'Registrasi berhasil! Silakan verifikasi email Anda.');
	}

	public function logout(Request $request)
	{
		Auth::logout();
		$request->session()->invalidate();
		$request->session()->regenerateToken();

		return redirect()->route('home')
			->with('success', 'Anda telah keluar.');
	}
}