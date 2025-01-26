@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">Register</div>
			<div class="card-body">
				<form method="POST" action="{{ route('register') }}">
					@csrf
					<div class="mb-3">
						<label for="nama" class="form-label">Name</label>
						<input type="text" class="form-control @error('nama') is-invalid @enderror" 
							id="nama" name="nama" value="{{ old('nama') }}" required autofocus>
						@error('nama')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="mb-3">
						<label for="phone" class="form-label">Phone Number</label>
						<input type="text" class="form-control @error('phone') is-invalid @enderror" 
							id="phone" name="phone" value="{{ old('phone') }}" required>
						@error('phone')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="mb-3">
						<label for="email" class="form-label">Email Address</label>
						<input type="email" class="form-control @error('email') is-invalid @enderror" 
							id="email" name="email" value="{{ old('email') }}" required>
						@error('email')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="mb-3">
						<label for="password" class="form-label">Password</label>
						<input type="password" class="form-control @error('password') is-invalid @enderror" 
							id="password" name="password" required>
						@error('password')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="mb-3">
						<label for="password_confirmation" class="form-label">Confirm Password</label>
						<input type="password" class="form-control" 
							id="password_confirmation" name="password_confirmation" required>
					</div>

					<div class="mb-3">
						<button type="submit" class="btn btn-primary">Register</button>
					</div>

					<div class="text-center">
						Already have an account? <a href="{{ route('login') }}">Login here</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection