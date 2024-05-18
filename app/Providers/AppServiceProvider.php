<?php

namespace App\Providers;

use App\Http\Controllers\PanganController;
use App\Models\Setting;
use App\Models\Pasar;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
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
        
        Paginator::useBootstrap();

        // dd($site_settings);


        // View::share('pasars', Pasar::all());

     
        View::share('settings', Setting::latest('created_at')->take(1)->get());
        Gate::define('admin',function(User $user){

            return $user->is_admin;
        });
        
    }
}
