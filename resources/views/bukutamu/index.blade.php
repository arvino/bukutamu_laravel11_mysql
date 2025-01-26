@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row mb-4">
		<div class="col">
			<h2>Guest Book Entries</h2>
		</div>
		@auth
			<div class="col-auto">
				<a href="{{ route('bukutamu.create') }}" class="btn btn-primary">Add New Entry</a>
			</div>
		@endauth
	</div>

	@foreach($entries as $entry)
		<div class="card mb-4">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-center mb-3">
					<h5 class="card-title">{{ $entry->member->nama }}</h5>
					<small class="text-muted">{{ $entry->created_at->format('d M Y H:i') }}</small>
				</div>
				
				<p class="card-text">{{ $entry->messages }}</p>
				
				@if($entry->gambar)
					<img src="{{ Storage::url($entry->gambar) }}" alt="Entry Image" class="img-fluid mb-3" style="max-height: 300px;">
				@endif

				<div class="d-flex justify-content-between align-items-center">
					<a href="{{ route('bukutamu.show', $entry) }}" class="btn btn-sm btn-info">View Details</a>
					
					@auth
						@if(auth()->user()->isAdmin() || auth()->id() === $entry->member_id)
							<div>
								<a href="{{ route('bukutamu.edit', $entry) }}" class="btn btn-sm btn-warning">Edit</a>
								@if(auth()->user()->isAdmin())
									<form action="{{ route('bukutamu.destroy', $entry) }}" method="POST" class="d-inline">
										@csrf
										@method('DELETE')
										<button type="submit" class="btn btn-sm btn-danger" 
											onclick="return confirm('Are you sure you want to delete this entry?')">
											Delete
										</button>
									</form>
								@endif
							</div>
						@endif
					@endauth
				</div>
			</div>
		</div>
	@endforeach

	<div class="d-flex justify-content-center">
		{{ $entries->links() }}
	</div>
</div>
@endsection