<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ config('app.name') }} - @yield('title')</title>
	
	<!-- CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
	@stack('styles')
</head>
<body>
	<!-- Navbar -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
		<div class="container">
			<a class="navbar-brand" href="{{ route('home') }}">{{ config('app.name', 'Laravel') }}</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav me-auto">
					<li class="nav-item">
						<a class="nav-link" href="{{ route('home') }}">Beranda</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('home') }}">Buku Tamu</a>
					</li>
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
						@if(auth()->user()->isAdmin())
							<li class="nav-item">
								<a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
							</li>
						@endif
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
								{{ auth()->user()->nama }}
							</a>
							<ul class="dropdown-menu dropdown-menu-end">
								<li>
									<a class="dropdown-item" href="{{ route('profile.edit') }}">
										Profil
									</a>
								</li>
								<li><hr class="dropdown-divider"></li>
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

	<!-- Content -->
	<main class="py-4">
		<div class="container">
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
		</div>
	</main>

	<!-- Scripts -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	@stack('scripts')
</body>
</html>