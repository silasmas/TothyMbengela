<?php

namespace App\Providers;

use App\Models\Book;
use App\Models\PastorActivity;
use App\Models\ShopSetting;
use App\Models\SiteSetting;
use App\Models\Slide;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View as ViewInstance;

/**
 * Fournisseur d’application : pagination, données partagées layout.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Enregistre les services de l’application.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Initialise pagination Bootstrap et données layout (modales / slider / devises).
     *
     * @return void
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        View::composer('layouts.app', function (ViewInstance $view): void {
            $view->with(
                'pastorWelcomeModalActivities',
                PastorActivity::forWelcomeModal(),
            );

            $siteSetting = Schema::hasTable('site_settings')
                ? SiteSetting::instance()
                : null;
            $view->with('siteSetting', $siteSetting);

            $productsWelcomeModalEnabled = $siteSetting
                ? $siteSetting->isProductsWelcomeModalEnabled()
                : true;

            $featuredProducts = collect();
            if (
                $productsWelcomeModalEnabled
                && Schema::hasColumn('books', 'is_featured')
            ) {
                $featuredProducts = Book::query()->featuredForPromo()->take(8)->get();
            }
            $view->with('featuredProducts', $featuredProducts);
            $view->with('productsWelcomeModalEnabled', $productsWelcomeModalEnabled);

            $homeSlides = collect();
            if (Schema::hasTable('slides')) {
                $homeSlides = Slide::query()
                    ->activeOrdered()
                    ->with('book')
                    ->get();
            }
            $view->with('homeSlides', $homeSlides);

            $shopSetting = Schema::hasTable('shop_settings')
                ? ShopSetting::instance()
                : null;
            $view->with('shopSetting', $shopSetting);
        });
    }
}
