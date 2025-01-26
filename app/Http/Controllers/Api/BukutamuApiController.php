<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bukutamu;
use Illuminate\Http\Request;

class BukutamuApiController extends Controller
{
    public function index()
    {
        $bukutamus = Bukutamu::with('member')->latest()->paginate(10);
        return response()->json($bukutamus);
    }

    public function store(Request $request)
    {
        $request->validate([
            'messages' => 'required|string',
            'gambar' => 'nullable|image|max:2048'
        ]);

        if (!auth()->user()->canSubmitToday()) {
            return response()->json([
                'message' => 'Anda sudah submit pesan hari ini'
            ], 403);
        }

        $data = $request->all();
        $data['member_id'] = auth()->id();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('bukutamu', 'public');
        }

        $bukutamu = Bukutamu::create($data);

        return response()->json([
            'message' => 'Pesan berhasil ditambahkan',
            'data' => $bukutamu
        ], 201);
    }

    // Tambahkan method lain untuk API (show, update, destroy)
} 