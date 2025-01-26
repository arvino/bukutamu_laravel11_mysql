protected $middlewareAliases = [
	'auth' => \App\Http\Middleware\Authenticate::class,
	'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
	'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
	'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
	'can' => \Illuminate\Auth\Middleware\Authorize::class,
	'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
	'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
	'precognitive' => \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
	'signed' => \App\Http\Middleware\ValidateSignature::class,
	'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
	'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
	'role' => \App\Http\Middleware\CheckRole::class,
];