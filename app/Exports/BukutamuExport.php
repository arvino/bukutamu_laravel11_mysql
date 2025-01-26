<?php

namespace App\Exports;

use App\Models\Bukutamu;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\Storage;

class BukutamuExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Bukutamu::with('member')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Member',
            'Email Member',
            'Pesan',
            'Gambar',
            'Tanggal'
        ];
    }

    public function map($bukutamu): array
    {
        return [
            $bukutamu->id,
            $bukutamu->member->nama,
            $bukutamu->member->email,
            $bukutamu->messages,
            $bukutamu->gambar ? url(Storage::url($bukutamu->gambar)) : '-',
            $bukutamu->created_at->format('d/m/Y H:i:s')
        ];
    }
} 