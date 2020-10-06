<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $repos = array(
            'Todo',
            'User',
            'Course',
            'Subject',
            'CourseLevel'
        );
        foreach ($repos as $re) {
            $this->app->bind(
                "App\Repositories\\{$re}\\{$re}RepositoryInterface",
                "App\Repositories\\{$re}\\{$re}Repository");
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
