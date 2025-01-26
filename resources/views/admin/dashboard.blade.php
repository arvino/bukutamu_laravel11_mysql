@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container">
	<div class="row mb-4">
		<div class="col-md-6">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Total Member</h5>
					<p class="card-text display-4">{{ $totalMembers }}</p>
					<a href="{{ route('admin.members.index') }}" class="btn btn-primary">
						Kelola Member
					</a>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Total Buku Tamu</h5>
					<p class="card-text display-4">{{ $totalBukutamu }}</p>
					<a href="{{ route('admin.export.bukutamu') }}" class="btn btn-success">
						Export Data
					</a>
				</div>
			</div>
		</div>
	</div>

	<div class="card">
		<div class="card-header">
			<h5 class="mb-0">Buku Tamu Terbaru</h5>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th>Nama</th>
							<th>Pesan</th>
							<th>Tanggal</th>
						</tr>
					</thead>
					<tbody>
						@forelse($recentBukutamu as $bukutamu)
							<tr>
								<td>{{ $bukutamu->member->nama }}</td>
								<td>{{ Str::limit($bukutamu->messages, 50) }}</td>
								<td>{{ $bukutamu->created_at->format('d/m/Y H:i') }}</td>
							</tr>
						@empty
							<tr>
								<td colspan="3" class="text-center">Tidak ada data</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection