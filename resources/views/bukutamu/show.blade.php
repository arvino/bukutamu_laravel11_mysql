@extends('layouts.app')

@section('title', 'Detail Buku Tamu')

@section('content')
<div class="card">
	<div class="card-header">
		<h5 class="mb-0">Detail Buku Tamu</h5>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-6">
				<table class="table">
					<tr>
						<th width="200">Nama</th>
						<td>{{ $bukutamu->member->nama }}</td>
					</tr>
					<tr>
						<th>Pesan</th>
						<td>{{ $bukutamu->messages }}</td>
					</tr>
					<tr>
						<th>Tanggal</th>
						<td>{{ $bukutamu->created_at->format('d/m/Y H:i') }}</td>
					</tr>
				</table>
			</div>
			<div class="col-md-6">
				@if($bukutamu->gambar)
					<img src="{{ Storage::url($bukutamu->gambar) }}" 
						 alt="Gambar" class="img-fluid rounded">
				@else
					<div class="alert alert-info">
						Tidak ada gambar
					</div>
				@endif
			</div>
		</div>

		<div class="mt-3">
			<a href="{{ route('bukutamu.index') }}" class="btn btn-secondary">
				Kembali
			</a>
			
			@auth
				@if(auth()->user()->isAdmin() || auth()->id() === $bukutamu->member_id)
					<a href="{{ route('bukutamu.edit', $bukutamu) }}" 
					   class="btn btn-warning">
						Edit
					</a>
				@endif

				@if(auth()->user()->isAdmin())
					<form action="{{ route('bukutamu.destroy', $bukutamu) }}" 
						  method="POST" class="d-inline">
						@csrf
						@method('DELETE')
						<button type="submit" class="btn btn-danger"
								onclick="return confirm('Yakin ingin menghapus?')">
							Hapus
						</button>
					</form>
				@endif
			@endauth
		</div>
	</div>
</div>
@endsection