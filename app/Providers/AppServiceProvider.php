<?php

namespace App\Providers;

use App\Models\Chats;
use Illuminate\Routing\Route;
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
       // Share unreadMessageCount with the layout header view
        View::composer('layout.header', function ($view) {
            $unreadMessageCount = Chats::where('is_read', false)
                ->groupBy('contact_id') // Group by contact_id to count each contact once
                ->selectRaw('count(*) as total, contact_id') // Select the grouped contacts
                ->get()
                ->count(); // Count the number of unique contacts
            $view->with('unreadMessageCount', $unreadMessageCount);
        });
    }

    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

}
