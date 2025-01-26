@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">Edit Entry</div>
				<div class="card-body">
					<form action="{{ route('bukutamu.update', $bukutamu) }}" method="POST" enctype="multipart/form-data">
						@csrf
						@method('PUT')

						<div class="mb-3">
							<label for="messages" class="form-label">Message</label>
							<textarea class="form-control @error('messages') is-invalid @enderror" 
								id="messages" name="messages" rows="5" required>{{ old('messages', $bukutamu->messages) }}</textarea>
							@error('messages')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="mb-3">
							<label for="gambar" class="form-label">Image</label>
							@if($bukutamu->gambar)
								<div class="mb-2">
									<img src="{{ Storage::url($bukutamu->gambar) }}" alt="Current Image" 
										class="img-fluid" style="max-height: 300px;">
								</div>
							@endif
							<input type="file" class="form-control @error('gambar') is-invalid @enderror" 
								id="gambar" name="gambar" accept="image/*">
							@error('gambar')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="d-flex justify-content-between">
							<a href="{{ route('home') }}" class="btn btn-secondary">Kembali</a>
							<button type="submit" class="btn btn-primary">Update</button>
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
			const existingPreview = previewContainer.querySelector('img:not([src^="storage"])');
			if (existingPreview) {
				previewContainer.removeChild(existingPreview);
			}
			previewContainer.appendChild(preview);
		}
	};
</script>
@endpush