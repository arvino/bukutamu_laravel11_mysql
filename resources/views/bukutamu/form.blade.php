@extends('layouts.app')

@section('title', isset($bukutamu) ? 'Edit Buku Tamu' : 'Tambah Buku Tamu')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">{{ isset($bukutamu) ? 'Edit Buku Tamu' : 'Tambah Buku Tamu' }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ isset($bukutamu) ? route('bukutamu.update', $bukutamu) : route('bukutamu.store') }}"
              method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($bukutamu))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="messages" class="form-label">Pesan</label>
                <textarea name="messages" id="messages" rows="4" 
                          class="form-control @error('messages') is-invalid @enderror" 
                          required>{{ old('messages', $bukutamu->messages ?? '') }}</textarea>
                @error('messages')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar (Opsional)</label>
                <input type="file" name="gambar" id="gambar" 
                       class="form-control @error('gambar') is-invalid @enderror"
                       accept="image/*">
                @error('gambar')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                @if(isset($bukutamu) && $bukutamu->gambar)
                    <div class="mt-2">
                        <img src="{{ Storage::url($bukutamu->gambar) }}" 
                             alt="Current Image" class="img-thumbnail"
                             style="max-height: 200px">
                    </div>
                @endif
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('bukutamu.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    {{ isset($bukutamu) ? 'Update' : 'Simpan' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 