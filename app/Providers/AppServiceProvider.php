<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Composer;
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
        Paginator::useBootstrapFour();

        view()->composer('*', function ($view) {
            //Hiển thị số sản phẩm trong giỏ hàng
            $cart = session()->get('cart', []) ?? [];
            $count = collect($cart)->count('quantity');
            //Gửi $count lên tất cả các view
            $view->with('cart_count', $count);
            //Hoặc gửi tất cả các biến lên view
            // $view->with('*', compact('count'));
        });
    }
}