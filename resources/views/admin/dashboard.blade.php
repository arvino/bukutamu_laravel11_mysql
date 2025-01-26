@extends('layouts.app')

@section('content')
<div class="container">
	<h2 class="mb-4">Admin Dashboard</h2>

	<div class="row mb-4">
		<div class="col-md-6">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Total Members</h5>
					<p class="card-text display-4">{{ $totalMembers }}</p>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Total Entries</h5>
					<p class="card-text display-4">{{ $totalEntries }}</p>
				</div>
			</div>
		</div>
	</div>

	<div class="card mb-4">
		<div class="card-header">
			<h5 class="mb-0">Recent Entries</h5>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th>Author</th>
							<th>Message</th>
							<th>Date</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($recentEntries as $entry)
							<tr>
								<td>{{ $entry->member->nama }}</td>
								<td>{{ Str::limit($entry->messages, 50) }}</td>
								<td>{{ $entry->created_at->format('d M Y H:i') }}</td>
								<td>
									<a href="{{ route('bukutamu.show', $entry) }}" 
										class="btn btn-sm btn-info">View</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="card">
		<div class="card-header d-flex justify-content-between align-items-center">
			<h5 class="mb-0">Member Management</h5>
			<a href="{{ route('admin.members.index') }}" class="btn btn-primary">View All Members</a>
		</div>
	</div>
</div>
@endsection