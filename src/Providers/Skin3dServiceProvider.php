<?php

namespace Azuriom\Plugin\Skin3d\Providers;

use Azuriom\Extensions\Plugin\BasePluginServiceProvider;

class Skin3dServiceProvider extends BasePluginServiceProvider
{
    /**
     * The plugin's global HTTP middleware stack.
     */
    protected array $middleware = [
        // \Azuriom\Plugin\Skin3d\Middleware\ExampleMiddleware::class,
    ];

    /**
     * The plugin's route middleware groups.
     */
    protected array $middlewareGroups = [];

    /**
     * The plugin's route middleware.
     */
    protected array $routeMiddleware = [
        // 'example' => \Azuriom\Plugin\Skin3d\Middleware\ExampleRouteMiddleware::class,
    ];

    /**
     * The policy mappings for this plugin.
     *
     * @var array<string, string>
     */
    protected array $policies = [
        // User::class => UserPolicy::class,
    ];

    /**
     * Register any plugin services.
     */
    public function register(): void
    {
        // $this->registerMiddleware();

        //
    }

    /**
     * Bootstrap any plugin services.
     */
    public function boot(): void
    {
        // $this->registerPolicies();

        $this->loadViews();

        $this->loadTranslations();

        $this->loadMigrations();

        $this->registerRouteDescriptions();

        $this->registerAdminNavigation();

        $this->registerUserNavigation();

        //
    }

    /**
     * Returns the routes that should be able to be added to the navbar.
     *
     * @return array<string, string>
     */
    protected function routeDescriptions(): array
    {
        return [
            'skin3d.index' => "Skin3d viewer",
        ];
    }

    /**
     * Return the admin navigations routes to register in the dashboard.
     *
     * @return array<string, array<string, string>>
     */
    protected function adminNavigation(): array
    {
        return [
            'skin3d' => [
                'type' => 'dropdown',
                'name' => 'skin3D viewer',
                'icon' => 'bi bi-badge-3d',
                'route' => 'skin3d.admin.*',
                'items' => [
                    'skin3d.admin.index' => trans('skin3d::admin.sk3dviewer'),
                    'skin3d.admin.api' => trans('skin3d::admin.sk3dapi'),
                ],
            ],

        ];
    }

    /**
     * Return the user navigations routes to register in the user menu.
     *
     * @return array<string, array<string, string>>
     */
    protected function userNavigation(): array
    {
        return [
            'skin3d' => [
                'route' => 'skin3d.index',
                'icon' => 'bi bi-badge-3d',
                'name' => 'skin3D viewer',
            ],
        ];
    }
}
