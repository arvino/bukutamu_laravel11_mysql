use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;

class EventServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (app()->environment('local')) {
            Event::listen(Registered::class, function ($event) {
                $event->user->markEmailAsVerified();
            });
        }
    }
} 