@extends('layouts.app')

@section('title', 'Edit Member')

@section('content')
<div class="row justify-content-center">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<h5 class="mb-0">Edit Member</h5>
			</div>
			<div class="card-body">
				<form action="{{ route('admin.members.update', $member) }}" method="POST">
					@csrf
					@method('PUT')

					<div class="mb-3">
						<label for="nama" class="form-label">Nama</label>
						<input type="text" class="form-control @error('nama') is-invalid @enderror"
							   id="nama" name="nama" value="{{ old('nama', $member->nama) }}" required>
						@error('nama')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="mb-3">
						<label for="email" class="form-label">Email</label>
						<input type="email" class="form-control" value="{{ $member->email }}" 
							   disabled readonly>
						<small class="text-muted">Email tidak dapat diubah</small>
					</div>

					<div class="mb-3">
						<label for="phone" class="form-label">No. Telepon</label>
						<input type="tel" class="form-control @error('phone') is-invalid @enderror"
							   id="phone" name="phone" value="{{ old('phone', $member->phone) }}" required>
						@error('phone')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="mb-3">
						<label for="password" class="form-label">Password Baru (opsional)</label>
						<input type="password" class="form-control @error('password') is-invalid @enderror"
							   id="password" name="password">
						@error('password')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="mb-3">
						<label for="password_confirmation" class="form-label">Konfirmasi Password</label>
						<input type="password" class="form-control"
							   id="password_confirmation" name="password_confirmation">
					</div>

					<div class="d-flex justify-content-end gap-2">
						<a href="{{ route('admin.members.index') }}" class="btn btn-secondary">
							Kembali
						</a>
						<button type="submit" class="btn btn-primary">Update Member</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection