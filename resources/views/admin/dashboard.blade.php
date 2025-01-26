@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="row mb-4">
	<div class="col-md-4">
		<div class="card bg-primary text-white">
			<div class="card-body">
				<h5 class="card-title">Total Member</h5>
				<h2 class="mb-0">{{ $stats['total_members'] }}</h2>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card bg-success text-white">
			<div class="card-body">
				<h5 class="card-title">Total Buku Tamu</h5>
				<h2 class="mb-0">{{ $stats['total_entries'] }}</h2>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card bg-info text-white">
			<div class="card-body">
				<h5 class="card-title">Buku Tamu Hari Ini</h5>
				<h2 class="mb-0">{{ $stats['today_entries'] }}</h2>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header d-flex justify-content-between align-items-center">
				<h5 class="mb-0">Buku Tamu Terbaru</h5>
				<a href="{{ route('bukutamu.index') }}" class="btn btn-sm btn-primary">
					Lihat Semua
				</a>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Nama</th>
								<th>Pesan</th>
								<th>Tanggal</th>
							</tr>
						</thead>
						<tbody>
							@forelse($latest_entries as $entry)
								<tr>
									<td>{{ $entry->member->nama }}</td>
									<td>{{ Str::limit($entry->messages, 30) }}</td>
									<td>{{ $entry->created_at->format('d/m/Y H:i') }}</td>
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

	<div class="col-md-6">
		<div class="card">
			<div class="card-header d-flex justify-content-between align-items-center">
				<h5 class="mb-0">Member Terbaru</h5>
				<a href="{{ route('admin.members.index') }}" class="btn btn-sm btn-primary">
					Lihat Semua
				</a>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Nama</th>
								<th>Email</th>
								<th>Tanggal Daftar</th>
							</tr>
						</thead>
						<tbody>
							@forelse($latest_members as $member)
								<tr>
									<td>{{ $member->nama }}</td>
									<td>{{ $member->email }}</td>
									<td>{{ $member->created_at->format('d/m/Y') }}</td>
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
</div>
@endsection