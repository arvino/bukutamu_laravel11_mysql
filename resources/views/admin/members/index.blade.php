@extends('layouts.app')

@section('title', 'Manajemen Member')

@section('content')
<div class="container">
	<div class="d-flex justify-content-between align-items-center mb-4">
		<h2>Manajemen Member</h2>
		<div>
			<a href="{{ route('admin.members.create') }}" class="btn btn-primary">
				Tambah Member
			</a>
			<a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
				Kembali ke Dashboard
			</a>
		</div>
	</div>

	<div class="card">
		<div class="card-header">
			<h5 class="mb-0">Daftar Member</h5>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama</th>
							<th>Email</th>
							<th>Phone</th>
							<th>Status</th>
							<th>Tanggal Daftar</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@forelse($members as $member)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $member->nama }}</td>
								<td>{{ $member->email }}</td>
								<td>{{ $member->phone }}</td>
								<td>
									@if($member->email_verified_at)
										<span class="badge bg-success">Active</span>
									@else
										<span class="badge bg-warning">Pending</span>
									@endif
								</td>
								<td>{{ $member->created_at->format('d/m/Y H:i') }}</td>
								<td>
									<div class="d-flex gap-2">
										<a href="{{ route('admin.members.edit', $member) }}" 
											class="btn btn-sm btn-warning">Edit</a>
										<form action="{{ route('admin.members.destroy', $member) }}" 
											method="POST" class="d-inline">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-sm btn-danger"
												onclick="return confirm('Yakin ingin menghapus member ini?')">
												Hapus
											</button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="7" class="text-center">Tidak ada data</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>

			<div class="d-flex justify-content-center mt-4">
				{{ $members->links() }}
			</div>
		</div>
	</div>
</div>
@endsection