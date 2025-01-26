@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header d-flex justify-content-between align-items-center">
					<span>Entry Details</span>
					<a href="{{ route('bukutamu.index') }}" class="btn btn-sm btn-secondary">Back to List</a>
				</div>
				<div class="card-body">
					<div class="mb-4">
						<h5>Author</h5>
						<p>{{ $bukutamu->member->nama }}</p>
					</div>

					<div class="mb-4">
						<h5>Posted On</h5>
						<p>{{ $bukutamu->created_at->format('d M Y H:i') }}</p>
					</div>

					<div class="mb-4">
						<h5>Message</h5>
						<p>{{ $bukutamu->messages }}</p>
					</div>

					@if($bukutamu->gambar)
						<div class="mb-4">
							<h5>Image</h5>
							<img src="{{ Storage::url($bukutamu->gambar) }}" alt="Entry Image" 
								class="img-fluid" style="max-height: 400px;">
						</div>
					@endif

					@auth
						@if(auth()->user()->isAdmin() || auth()->id() === $bukutamu->member_id)
							<div class="mt-4 d-flex gap-2">
								<a href="{{ route('bukutamu.edit', $bukutamu) }}" 
									class="btn btn-warning">Edit Entry</a>
								
								@if(auth()->user()->isAdmin())
									<form action="{{ route('bukutamu.destroy', $bukutamu) }}" 
										method="POST" class="d-inline">
										@csrf
										@method('DELETE')
										<button type="submit" class="btn btn-danger" 
											onclick="return confirm('Are you sure you want to delete this entry?')">
											Delete Entry
										</button>
									</form>
								@endif
							</div>
						@endif
					@endauth
				</div>
			</div>
		</div>
	</div>
</div>
@endsection