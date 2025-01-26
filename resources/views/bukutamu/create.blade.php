@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">Add New Entry</div>
				<div class="card-body">
					<form action="{{ route('bukutamu.store') }}" method="POST" enctype="multipart/form-data">
						@csrf

						<div class="mb-3">
							<label for="messages" class="form-label">Message</label>
							<textarea class="form-control @error('messages') is-invalid @enderror" 
								id="messages" name="messages" rows="5" required>{{ old('messages') }}</textarea>
							@error('messages')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="mb-3">
							<label for="gambar" class="form-label">Image (Optional)</label>
							<input type="file" class="form-control @error('gambar') is-invalid @enderror" 
								id="gambar" name="gambar" accept="image/*">
							@error('gambar')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="d-flex justify-content-between">
							<button type="submit" class="btn btn-primary">Submit Entry</button>
							<a href="{{ route('bukutamu.index') }}" class="btn btn-secondary">Cancel</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script>
	// Preview image before upload
	document.getElementById('gambar').onchange = function(evt) {
		const [file] = this.files;
		if (file) {
			const preview = document.createElement('img');
			preview.src = URL.createObjectURL(file);
			preview.className = 'img-fluid mt-2';
			preview.style.maxHeight = '300px';
			
			const previewContainer = document.getElementById('gambar').parentNode;
			const existingPreview = previewContainer.querySelector('img');
			if (existingPreview) {
				previewContainer.removeChild(existingPreview);
			}
			previewContainer.appendChild(preview);
		}
	};
</script>
@endpush