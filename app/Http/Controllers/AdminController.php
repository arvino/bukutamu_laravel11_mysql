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
use Illuminate\Support\Facades\Storage;

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
		$totalBukutamu = Bukutamu::count();
		$recentBukutamu = Bukutamu::with('member')->latest()->take(5)->get();
		
		return view('admin.dashboard', compact('totalMembers', 'totalBukutamu', 'recentBukutamu'));
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
		if ($member->role === 'admin') {
			return redirect()->route('admin.members.index')
				->with('error', 'Tidak dapat mengedit admin');
		}
		return view('admin.members.edit', compact('member'));
	}

	public function updateMember(Request $request, Member $member)
	{
		if ($member->role === 'admin') {
			return redirect()->route('admin.members.index')
				->with('error', 'Tidak dapat mengedit admin');
		}

		$validated = $request->validate([
			'nama' => ['required', 'string', 'max:255'],
			'email' => ['required', 'email', 'max:255', 'unique:members,email,' . $member->id],
			'phone' => ['required', 'string', 'max:20'],
			'password' => ['nullable', 'min:8', 'confirmed'],
			'status' => ['required', 'in:active,inactive']
		]);

		$member->nama = $validated['nama'];
		$member->email = $validated['email'];
		$member->phone = $validated['phone'];
		
		if ($request->filled('password')) {
			$member->password = Hash::make($validated['password']);
		}

		if ($validated['status'] === 'inactive') {
			$member->email_verified_at = null;
		} elseif (!$member->email_verified_at) {
			$member->email_verified_at = now();
		}

		$member->save();

		return redirect()->route('admin.members.index')
			->with('success', 'Member berhasil diperbarui');
	}

	public function destroyMember(Member $member)
	{
		if ($member->role === 'admin') {
			return redirect()->route('admin.members.index')
				->with('error', 'Tidak dapat menghapus admin');
		}

		// Hapus semua bukutamu yang terkait
		foreach ($member->bukutamu as $bukutamu) {
			if ($bukutamu->gambar) {
				Storage::disk('public')->delete($bukutamu->gambar);
			}
			$bukutamu->delete();
		}

		$member->delete();

		return redirect()->route('admin.members.index')
			->with('success', 'Member berhasil dihapus');
	}

	public function exportBukutamu()
	{
		return Excel::download(new BukutamuExport, 'bukutamu.xlsx');
	}

	public function createMember()
	{
		return view('admin.members.create');
	}

	public function storeMember(Request $request)
	{
		$validated = $request->validate([
			'nama' => ['required', 'string', 'max:255'],
			'email' => ['required', 'email', 'unique:members,email'],
			'phone' => ['required', 'string', 'max:20'],
			'password' => ['required', 'min:8', 'confirmed'],
			'status' => ['required', 'in:active,inactive']
		]);

		$member = new Member();
		$member->nama = $validated['nama'];
		$member->email = $validated['email'];
		$member->phone = $validated['phone'];
		$member->password = Hash::make($validated['password']);
		$member->role = 'member';
		
		if ($validated['status'] === 'active') {
			$member->email_verified_at = now();
		}

		$member->save();

		return redirect()->route('admin.members.index')
			->with('success', 'Member berhasil ditambahkan');
	}
}