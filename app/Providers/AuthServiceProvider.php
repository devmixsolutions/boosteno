<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Access;
use App\Models\Permissions;
use App\Models\SubCategories;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
  
        Passport::routes();

        Gate::define('read', function (User $user) {
            $userRole = $user->userRole->role->id;
            $currentRoute = SubCategories::where("link",Route::currentRouteName())->pluck("id")->first();
            $permission = Permissions::where(["roles_id"=>$userRole,"sub_categories_id"=>$currentRoute])->pluck("can_read")->first();
            return $permission;
        });

        Gate::define('create', function (User $user) {
            $userRole = $user->userRole->role->id;
            $currentRoute = SubCategories::where("link",Route::currentRouteName())->pluck("id")->first();
            $permission = Permissions::where(["roles_id"=>$userRole,"sub_categories_id"=>$currentRoute])->pluck("can_create")->first();
            return $permission;
        });

        Gate::define('update', function (User $user) {
            $userRole = $user->userRole->role->id;
            $currentRoute = SubCategories::where("link",Route::currentRouteName())->pluck("id")->first();
            $permission = Permissions::where(["roles_id"=>$userRole,"sub_categories_id"=>$currentRoute])->pluck("can_update")->first();
            return $permission;
        });

        Gate::define('delete', function (User $user) {
            $userRole = $user->userRole->role->id;
            $currentRoute = SubCategories::where("link",Route::currentRouteName())->pluck("id")->first();
            $permission = Permissions::where(["roles_id"=>$userRole,"sub_categories_id"=>$currentRoute])->pluck("can_delete")->first();
            return $permission;
        });
        
    }
}
