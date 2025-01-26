<?php

namespace App\Http\Controllers;

use App\Models\Bukutamu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukutamuController extends Controller
{
	public function index()
	{
		$entries = Bukutamu::with('member')->latest()->paginate(10);
		return view('bukutamu.index', compact('entries'));
	}

	public function create()
	{
		if (auth()->user()->hasPostedToday()) {
			return redirect()->route('bukutamu.index')
				->with('error', 'You can only post once per day.');
		}
		return view('bukutamu.create');
	}

	public function store(Request $request)
	{
		if (auth()->user()->hasPostedToday()) {
			return back()->with('error', 'You can only post once per day.');
		}

		$validated = $request->validate([
			'messages' => 'required|string|max:1000',
			'gambar' => 'nullable|image|max:2048'
		]);

		$entry = new Bukutamu($validated);
		$entry->member_id = auth()->id();

		if ($request->hasFile('gambar')) {
			$path = $request->file('gambar')->store('bukutamu', 'public');
			$entry->gambar = $path;
		}

		$entry->save();
		return redirect()->route('bukutamu.index')->with('success', 'Entry created successfully.');
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