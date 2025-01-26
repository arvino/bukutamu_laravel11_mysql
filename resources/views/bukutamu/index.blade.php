@extends('layouts.app')

@section('title', 'Daftar Buku Tamu')

@section('content')
<div class="card">
	<div class="card-header d-flex justify-content-between align-items-center">
		<h5 class="mb-0">Daftar Buku Tamu</h5>
		@auth
			@if(auth()->user()->canSubmitToday())
				<a href="{{ route('bukutamu.create') }}" class="btn btn-primary">
					Tambah Pesan
				</a>
			@endif
		@endauth
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Pesan</th>
						<th>Gambar</th>
						<th>Tanggal</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					@forelse($bukutamus as $bukutamu)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>{{ $bukutamu->member->nama }}</td>
							<td>{{ Str::limit($bukutamu->messages, 50) }}</td>
							<td>
								@if($bukutamu->gambar)
									<img src="{{ Storage::url($bukutamu->gambar) }}" 
										 alt="Gambar" class="img-thumbnail" 
										 style="max-height: 50px">
								@else
									-
								@endif
							</td>
							<td>{{ $bukutamu->created_at->format('d/m/Y H:i') }}</td>
							<td>
								<a href="{{ route('bukutamu.show', $bukutamu) }}" 
								   class="btn btn-sm btn-info">
									Detail
								</a>
								
								@auth
									@if(auth()->user()->isAdmin() || auth()->id() === $bukutamu->member_id)
										<a href="{{ route('bukutamu.edit', $bukutamu) }}" 
										   class="btn btn-sm btn-warning">
											Edit
										</a>
									@endif

									@if(auth()->user()->isAdmin())
										<form action="{{ route('bukutamu.destroy', $bukutamu) }}" 
											  method="POST" class="d-inline">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-sm btn-danger"
													onclick="return confirm('Yakin ingin menghapus?')">
												Hapus
											</button>
										</form>
									@endif
								@endauth
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="6" class="text-center">Tidak ada data</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>
		
		{{ $bukutamus->links() }}
	</div>
</div>
@endsection