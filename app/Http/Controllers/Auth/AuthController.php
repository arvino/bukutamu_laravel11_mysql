<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

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

		if (Auth::attempt($credentials)) {
			$request->session()->regenerate();
			return redirect()->intended('/dashboard');
		}

		return back()->withErrors([
			'email' => 'The provided credentials do not match our records.',
		]);
	}

	public function showRegister()
	{
		return view('auth.register');
	}

	public function register(Request $request)
	{
		$request->validate([
			'nama' => ['required', 'string', 'max:255'],
			'phone' => ['required', 'string', 'max:20'],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:members'],
			'password' => ['required', 'confirmed', Password::defaults()],
		]);

		$member = Member::create([
			'nama' => $request->nama,
			'phone' => $request->phone,
			'email' => $request->email,
			'password' => Hash::make($request->password),
		]);

		Auth::login($member);
		return redirect('/dashboard');
	}

	public function logout(Request $request)
	{
		Auth::logout();
		$request->session()->invalidate();
		$request->session()->regenerateToken();
		return redirect('/');
	}
}