<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
#use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $name = $user->name;
                $role = ucfirst($user->role);
                
                // Log current verification state for debugging
                Log::info('View composer - authenticated user', ['user_id' => $user->id, 'is_verified' => $user->is_verified]);

                // Avatar handling - check if it's a full URL or local file
                if ($user->provider) {
                    // For SSO providers (Google, Discord, etc), use the URL directly
                    $avatar = $user->avatar;
                } else {
                    // For local users, use asset() for proper URL
                    $avatar = asset('assets/images/user/' . ($user->avatar ?? 'avatar-5.jpg'));
                }
                
                // Get unread notifications
                $unreadNotifications = \App\Models\Notification::where('user_id', $user->id)
                    ->where('is_read', false)
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();

                $view->with(compact('user', 'name', 'role', 'avatar', 'unreadNotifications'));
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in local environment
        #if ($this->app->environment('local')) {
       #     URL::forceRootUrl(config('app.url'));
       #     URL::forceScheme('https');
       # }

        // Registrasi morph map untuk polymorphic relationships
        \Illuminate\Database\Eloquent\Relations\Relation::enforceMorphMap([
            'surat' => \App\Models\Surat::class,
            'pengaduan' => \App\Models\Pengaduan::class,
        ]);

        Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
            $event->extendSocialite('discord', \SocialiteProviders\Discord\Provider::class);
        });
    }
}
