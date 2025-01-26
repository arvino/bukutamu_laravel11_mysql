<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
	public function __construct()
	{
		$this->middleware('role:admin');
	}

	public function index()
	{
		$members = Member::where('role', 'member')->paginate(10);
		return view('admin.members.index', compact('members'));
	}

	public function edit(Member $member)
	{
		return view('admin.members.edit', compact('member'));
	}

	public function update(Request $request, Member $member)
	{
		$validated = $request->validate([
			'nama' => ['required', 'string', 'max:255'],
			'phone' => ['required', 'string', 'max:20'],
			'email' => ['required', 'email', Rule::unique('members')->ignore($member->id)],
			'password' => ['nullable', 'min:8', 'confirmed'],
		]);

		if (isset($validated['password'])) {
			$validated['password'] = Hash::make($validated['password']);
		} else {
			unset($validated['password']);
		}

		$member->update($validated);
		return redirect()->route('admin.members.index')
			->with('success', 'Member updated successfully');
	}

	public function destroy(Member $member)
	{
		if ($member->role === 'admin') {
			return back()->with('error', 'Cannot delete admin users');
		}

		$member->delete();
		return redirect()->route('admin.members.index')
			->with('success', 'Member deleted successfully');
	}

	public function dashboard()
	{
		$totalMembers = Member::where('role', 'member')->count();
		$totalEntries = \App\Models\Bukutamu::count();
		$recentEntries = \App\Models\Bukutamu::with('member')
			->latest()
			->take(5)
			->get();

		return view('admin.dashboard', compact('totalMembers', 'totalEntries', 'recentEntries'));
	}
}