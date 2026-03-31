<?php

namespace App\Providers;

use App\Models\PastorActivity;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View as ViewInstance;

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

        View::composer('layouts.app', function (ViewInstance $view): void {
            $view->with(
                'pastorWelcomeModalActivities',
                PastorActivity::forWelcomeModal(),
            );
        });
    }
}
