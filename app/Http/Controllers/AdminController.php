<?php

namespace App\Http\Controllers;

use App\Models\Bukutamu;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use App\Exports\BukutamuExport;
use Maatwebsite\Excel\Facades\Excel;

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
		$stats = [
			'total_members' => Member::where('role', 'member')->count(),
			'total_entries' => Bukutamu::count(),
			'today_entries' => Bukutamu::whereDate('created_at', today())->count(),
		];

		$latest_entries = Bukutamu::with('member')
			->latest()
			->take(5)
			->get();

		$latest_members = Member::where('role', 'member')
			->latest()
			->take(5)
			->get();

		return view('admin.dashboard', compact('stats', 'latest_entries', 'latest_members'));
	}

	public function members()
	{
		$members = Member::where('role', 'member')
			->latest()
			->paginate(10);

		return view('admin.members.index', compact('members'));
	}

	public function editMember(Member $member)
	{
		return view('admin.members.edit', compact('member'));
	}

	public function updateMember(Request $request, Member $member)
	{
		$validated = $request->validate([
			'nama' => ['required', 'string', 'max:255'],
			'phone' => ['required', 'string', 'max:20'],
			'password' => ['nullable', 'confirmed', Password::defaults()],
		]);

		$member->nama = $validated['nama'];
		$member->phone = $validated['phone'];

		if ($request->filled('password')) {
			$member->password = Hash::make($validated['password']);
		}

		$member->save();

		return redirect()->route('admin.members.index')
			->with('success', 'Member berhasil diperbarui.');
	}

	public function destroyMember(Member $member)
	{
		$member->delete();
		return back()->with('success', 'Member berhasil dihapus.');
	}

	public function exportBukutamu()
	{
		return Excel::download(new BukutamuExport, 'bukutamu.xlsx');
	}
}