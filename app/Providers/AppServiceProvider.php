<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        View::composer('*', function ($view) {
            if(Auth::check()){
                $newCompaniesCount = Auth::user()->unreadNotifications
                    ->where('type', 'App\Notifications\NouvelleEntrepriseNotification')
                    ->count();
                    $newDemandsCount = Auth::user()->unreadNotifications
                    ->where('type', 'App\Notifications\NouvelleDemandeNotification')
                    ->count();
                $totalNotifications = Auth::user()->unreadNotifications->count();
            } else {
                $newCompaniesCount = 0;
                $newDemandsCount = 0;
                $totalNotifications = 0;
            }
            $view->with(compact('newCompaniesCount', 'newDemandsCount', 'totalNotifications'));
        });
    }
}
