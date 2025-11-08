<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use App\Models\Product;

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
        // Share navbar data with caching to improve performance
        View::composer('components.partials.navbar', function ($view) {
            // Cache stock alerts for 2 minutes to reduce database queries
            $lowStockData = Cache::remember('navbar_stock_alerts', 120, function () {
                $lowStockBase = Product::where('status', 'active');
                
                $lowStockQuery = (clone $lowStockBase)
                    ->whereRaw('stock_quantity <= (critical_level * 1.5)')
                    ->orderBy('updated_at', 'desc');
                
                $lowStockCount = (clone $lowStockQuery)->count();
                $criticalCount = (clone $lowStockBase)
                    ->whereRaw('stock_quantity <= critical_level')
                    ->count();
                
                $lowStockItems = (clone $lowStockQuery)->take(6)->get();
                
                return [
                    'lowStockCount' => $lowStockCount,
                    'criticalCount' => $criticalCount,
                    'lowStockItems' => $lowStockItems,
                    'viewAllStatus' => 'alerts',
                ];
            });
            
            $view->with($lowStockData);
        });
    }
}
