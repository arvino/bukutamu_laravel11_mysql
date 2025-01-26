@extends('layouts.app')

@section('content')
<div class="container">
	<div class="d-flex justify-content-between align-items-center mb-4">
		<h2>Member Management</h2>
		<a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
	</div>

	<div class="card">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th>Name</th>
							<th>Email</th>
							<th>Phone</th>
							<th>Joined Date</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($members as $member)
							<tr>
								<td>{{ $member->nama }}</td>
								<td>{{ $member->email }}</td>
								<td>{{ $member->phone }}</td>
								<td>{{ $member->created_at->format('d M Y') }}</td>
								<td>
									<div class="d-flex gap-2">
										<a href="{{ route('admin.members.edit', $member) }}" 
											class="btn btn-sm btn-warning">Edit</a>
										<form action="{{ route('admin.members.destroy', $member) }}" 
											method="POST" class="d-inline">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-sm btn-danger"
												onclick="return confirm('Are you sure you want to delete this member?')">
												Delete
											</button>
										</form>
									</div>
								</td>
							</tr>
						@endforeach
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