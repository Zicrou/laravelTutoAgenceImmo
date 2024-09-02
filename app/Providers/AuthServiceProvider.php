<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\ImageUpload;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Property;
use App\Policies\ImageUploadPolicy;
use App\Policies\PropertyPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Property::class => PropertyPolicy::class,
        ImageUpload::class => ImageUploadPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
