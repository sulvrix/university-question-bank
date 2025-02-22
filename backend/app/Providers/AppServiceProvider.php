<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\View\Components\UsersComponent;
use App\View\Components\DepartmentsComponent;
use App\View\Components\FacultiesComponent;

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
        blade::component('users-component', UsersComponent::class);
        blade::component('departments-component', DepartmentsComponent::class);
        blade::component('faculties-component', FacultiesComponent::class);
    }
}
