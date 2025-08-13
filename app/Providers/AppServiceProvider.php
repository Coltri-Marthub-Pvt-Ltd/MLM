<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Badge;

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
        Paginator::useBootstrapFive();

           // Make $currentBadge available to all views
        View::composer('*', function ($view) {
        $contractor = Auth::guard('contractor')->user();

        // If contractor is logged in, fetch earned badges
        if ($contractor) {
            $currentBadge = Badge::getAllEarnedBadges($contractor->points);
        } else {
            $currentBadge = collect();
        }

        $view->with('currentBadge', $currentBadge);
    });
    }
}
