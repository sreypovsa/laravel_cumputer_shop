<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Models\Category;

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
        Schema::defaultStringLength(191);

        View::composer('*', function ($view) {
            $cart = session()->get('cart', []);
            $cartCount = array_sum(array_column($cart, 'quantity'));
            $cartSubtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
            
            // Only query if DB table exists
            $navCategories = [];
            try {
                if (Schema::hasTable('categories')) {
                    $navCategories = Category::withCount('products')->take(8)->get();
                }
            } catch (\Exception $e) {}

            $view->with([
                'globalCartCount' => $cartCount,
                'globalCartSubtotal' => $cartSubtotal,
                'globalCart' => $cart,
                'globalCategories' => $navCategories,
            ]);
        });
    }
}
