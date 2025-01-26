<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ config('app.name', 'Buku Tamu') }}</title>
	
	<!-- Bootstrap 5 CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Custom CSS -->
	@vite(['resources/css/app.css'])
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container">
			<a class="navbar-brand" href="{{ url('/') }}">Buku Tamu</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav me-auto">
					<li class="nav-item">
						<a class="nav-link" href="{{ route('home') }}">Home</a>
					</li>
					@auth
						<li class="nav-item">
							<a class="nav-link" href="{{ route('bukutamu.create') }}">Add Entry</a>
						</li>
						@if(auth()->user()->isAdmin())
							<li class="nav-item">
								<a class="nav-link" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
							</li>
						@endif
					@endauth
				</ul>
				<ul class="navbar-nav">
					@guest
						<li class="nav-item">
							<a class="nav-link" href="{{ route('login') }}">Login</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="{{ route('register') }}">Register</a>
						</li>
					@else
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
								{{ auth()->user()->nama }}
							</a>
							<ul class="dropdown-menu dropdown-menu-end">
								<li>
									<form action="{{ route('logout') }}" method="POST">
										@csrf
										<button type="submit" class="dropdown-item">Logout</button>
									</form>
								</li>
							</ul>
						</li>
					@endguest
				</ul>
			</div>
		</div>
	</nav>

	<main class="container py-4">
		@if(session('success'))
			<div class="alert alert-success">
				{{ session('success') }}
			</div>
		@endif

		@if(session('error'))
			<div class="alert alert-danger">
				{{ session('error') }}
			</div>
		@endif

		@yield('content')
	</main>

	<!-- Bootstrap 5 JS -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
	<!-- jQuery -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<!-- Custom JS -->
	@vite(['resources/js/app.js'])
	@stack('scripts')
</body>
</html>