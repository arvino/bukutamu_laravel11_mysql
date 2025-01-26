<?php

namespace App\Http\Controllers;

use App\Models\Bukutamu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukutamuController extends Controller
{
	public function index(Request $request)
	{
		$query = Bukutamu::with('member');

		// Filter berdasarkan tanggal
		if ($request->filled('date_from')) {
			$query->whereDate('created_at', '>=', $request->date_from);
		}
		if ($request->filled('date_to')) {
			$query->whereDate('created_at', '<=', $request->date_to);
		}

		// Pencarian berdasarkan nama/pesan
		if ($request->filled('search')) {
			$search = $request->search;
			$query->where(function($q) use ($search) {
				$q->whereHas('member', function($q) use ($search) {
					$q->where('nama', 'like', "%{$search}%");
				})->orWhere('messages', 'like', "%{$search}%");
			});
		}

		$bukutamus = $query->latest()->paginate(10);
		return view('bukutamu.index', compact('bukutamus'));
	}

	public function create()
	{
		if (!auth()->user()->canSubmitToday()) {
			return redirect()->route('bukutamu.index')
				->with('error', 'Anda sudah submit pesan hari ini');
		}
		return view('bukutamu.create');
	}

	public function store(Request $request)
	{
		$request->validate([
			'messages' => 'required|string',
			'gambar' => 'nullable|image|max:2048'
		]);

		if (!auth()->user()->canSubmitToday()) {
			return redirect()->route('bukutamu.index')
				->with('error', 'Anda sudah submit pesan hari ini');
		}

		$data = $request->all();
		$data['member_id'] = auth()->id();

		if ($request->hasFile('gambar')) {
			$data['gambar'] = $request->file('gambar')->store('bukutamu', 'public');
		}

		Bukutamu::create($data);

		return redirect()->route('bukutamu.index')
			->with('success', 'Pesan berhasil ditambahkan');
	}

	public function show(Bukutamu $bukutamu)
	{
		return view('bukutamu.show', compact('bukutamu'));
	}

	public function edit(Bukutamu $bukutamu)
	{
		if (!auth()->user()->isAdmin() && $bukutamu->member_id !== auth()->id()) {
			return redirect()->route('bukutamu.index')
				->with('error', 'Unauthorized access.');
		}
		return view('bukutamu.edit', compact('bukutamu'));
	}

	public function update(Request $request, Bukutamu $bukutamu)
	{
		if (!auth()->user()->isAdmin() && $bukutamu->member_id !== auth()->id()) {
			return redirect()->route('bukutamu.index')
				->with('error', 'Unauthorized access.');
		}

		$validated = $request->validate([
			'messages' => 'required|string|max:1000',
			'gambar' => 'nullable|image|max:2048'
		]);

		if ($request->hasFile('gambar')) {
			if ($bukutamu->gambar) {
				Storage::disk('public')->delete($bukutamu->gambar);
			}
			$path = $request->file('gambar')->store('bukutamu', 'public');
			$validated['gambar'] = $path;
		}

		$bukutamu->update($validated);
		return redirect()->route('bukutamu.show', $bukutamu)
			->with('success', 'Entry updated successfully.');
	}

	public function destroy(Bukutamu $bukutamu)
	{
		if (!auth()->user()->isAdmin()) {
			return redirect()->route('bukutamu.index')
				->with('error', 'Unauthorized access.');
		}

		if ($bukutamu->gambar) {
			Storage::disk('public')->delete($bukutamu->gambar);
		}

		$bukutamu->delete();
		return redirect()->route('bukutamu.index')
			->with('success', 'Entry deleted successfully.');
	}
}