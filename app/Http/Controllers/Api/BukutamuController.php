<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bukutamu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukutamuController extends Controller
{
	public function index()
	{
		$entries = Bukutamu::with('member')->latest()->paginate(10);
		return response()->json($entries);
	}

	public function store(Request $request)
	{
		if (auth()->user()->hasPostedToday()) {
			return response()->json(['error' => 'You can only post once per day.'], 403);
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
		return response()->json($entry, 201);
	}

	public function show(Bukutamu $bukutamu)
	{
		return response()->json($bukutamu->load('member'));
	}

	public function update(Request $request, Bukutamu $bukutamu)
	{
		if (!auth()->user()->isAdmin() && $bukutamu->member_id !== auth()->id()) {
			return response()->json(['error' => 'Unauthorized access'], 403);
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
		return response()->json($bukutamu);
	}

	public function destroy(Bukutamu $bukutamu)
	{
		if (!auth()->user()->isAdmin()) {
			return response()->json(['error' => 'Unauthorized access'], 403);
		}

		if ($bukutamu->gambar) {
			Storage::disk('public')->delete($bukutamu->gambar);
		}

		$bukutamu->delete();
		return response()->json(null, 204);
	}
}