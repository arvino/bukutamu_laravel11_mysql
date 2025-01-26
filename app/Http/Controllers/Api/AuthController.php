<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
	public function register(Request $request)
	{
		$validated = $request->validate([
			'nama' => ['required', 'string', 'max:255'],
			'phone' => ['required', 'string', 'max:20'],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:members'],
			'password' => ['required', 'confirmed', Password::defaults()],
		]);

		$member = Member::create([
			'nama' => $validated['nama'],
			'phone' => $validated['phone'],
			'email' => $validated['email'],
			'password' => Hash::make($validated['password']),
		]);

		$token = $member->createToken('auth_token')->plainTextToken;

		return response()->json([
			'access_token' => $token,
			'token_type' => 'Bearer',
			'member' => $member
		], 201);
	}

	public function login(Request $request)
	{
		$validated = $request->validate([
			'email' => 'required|email',
			'password' => 'required'
		]);

		if (!Auth::attempt($validated)) {
			return response()->json([
				'message' => 'Invalid login credentials'
			], 401);
		}

		$member = Member::where('email', $validated['email'])->firstOrFail();
		$token = $member->createToken('auth_token')->plainTextToken;

		return response()->json([
			'access_token' => $token,
			'token_type' => 'Bearer',
			'member' => $member
		]);
	}

	public function logout(Request $request)
	{
		$request->user()->currentAccessToken()->delete();
		return response()->json(['message' => 'Logged out successfully']);
	}

	public function profile(Request $request)
	{
		return response()->json($request->user());
	}

	public function updateProfile(Request $request)
	{
		$member = $request->user();
		
		$validated = $request->validate([
			'nama' => ['required', 'string', 'max:255'],
			'phone' => ['required', 'string', 'max:20'],
			'password' => ['nullable', 'confirmed', Password::defaults()],
		]);

		if (isset($validated['password'])) {
			$validated['password'] = Hash::make($validated['password']);
		} else {
			unset($validated['password']);
		}

		$member->update($validated);
		return response()->json($member);
	}
}