<?php

namespace App\Providers;

use App\Models\Notifications;
use App\Models\User;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['layout.master'], function ($view) {
            $user = auth()->user();
            $notifications = $user->notifications;

            $view->with(['notifications' => $notifications]);
        });
    }
}
