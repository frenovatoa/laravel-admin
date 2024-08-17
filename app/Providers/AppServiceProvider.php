<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

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
        JsonResource::withoutWrapping(); // This will remove the wrapping of the data.

        // A Gate is a way to define authorization logic in the application.
        \Gate::define('view', function(User $user, $model) {
            // return false; //! This will unauthorize the user to view the data.
            return $user->hasAccess("view_{$model}") || $user->hasAccess("edit_{$model}");
        });

        \Gate::define('edit', function(User $user, $model) {
            return $user->hasAccess("edit_{$model}");
        });
    }
}
