<?php

namespace App\Providers;

use App\Repositories\AdminRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ColorRepository;
use App\Repositories\RoleRepository;
use App\Repositories\SizeRepository;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\ColorRepositoryInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\SizeRepositoryInterface;
use App\Repositories\ProductRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
// use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );

        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );

        $this->app->bind(
            ColorRepositoryInterface::class,
            ColorRepository::class
        );

        $this->app->bind(
            SizeRepositoryInterface::class,
            SizeRepository::class
        );

        $this->app->bind(
            AdminRepositoryInterface::class,
            AdminRepository::class
        );

        $this->app->bind(
            RoleRepositoryInterface::class,
            RoleRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(125);

        // Set Carbon locale based on app locale for dashboard routes
        if (request()->is('dashboard*')) {
            $locale = session('locale', config('app.locale'));
            if (in_array($locale, ['en', 'ar'])) {
                // Set Carbon locale (ar for Arabic, en for English)
                Carbon::setLocale($locale);
            }
        }

        // Passport::tokensExpireIn(now()->addDays(15));
        // Passport::refreshTokensExpireIn(now()->addDays(30));
    }
}
