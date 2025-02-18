<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Tag\TagRepositoryInterface;
use App\Repositories\Contact\ContactRepositoryInterface;
#InterfaceNamespace
use App\Repositories\User\UserEloquentRepository;
use App\Repositories\Tag\TagEloquentRepository;
use App\Repositories\Contact\ContactEloquentRepository;
#ClassNamespace

/**
 * Class RepositoryServiceProvider
 *
 * @package App\Providers
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(UserRepositoryInterface::class, UserEloquentRepository::class);
		$this->app->singleton(TagRepositoryInterface::class, TagEloquentRepository::class);
		$this->app->singleton(ContactRepositoryInterface::class, ContactEloquentRepository::class);
		#Singleton
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            UserRepositoryInterface::class,
			TagRepositoryInterface::class,
			ContactRepositoryInterface::class,
			#InterfaceProvides
        ];
    }
}
