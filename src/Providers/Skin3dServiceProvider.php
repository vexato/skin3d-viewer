<?php

namespace Azuriom\Plugin\Skin3d\Providers;

use Azuriom\Extensions\Plugin\BasePluginServiceProvider;

class Skin3dServiceProvider extends BasePluginServiceProvider
{
    /**
     * Register any plugin services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any plugin services.
     */
    public function boot(): void
    {
        $this->loadViews();
        $this->loadTranslations();
        $this->loadMigrations();
        $this->registerRouteDescriptions();
        $this->registerAdminNavigation();
        $this->registerUserNavigation();
    }

    /**
     * Routes that can be added to the navbar.
     */
    protected function routeDescriptions(): array
    {
        return [
            'skin3d.index' => 'Skin3d viewer',
        ];
    }

    /**
     * Admin navigation routes.
     */
    protected function adminNavigation(): array
    {
        $items = [
            'skin3d.admin.index' => trans('skin3d::admin.sk3dviewer'),
        ];

        if (game()->id() !== 'mc-bedrock' && game()->id() !== 'hytale') {
            $items['skin3d.admin.api'] = trans('skin3d::admin.sk3dapi');
        }

        return [
            'skin3d' => [
                'type' => 'dropdown',
                'name' => 'skin3D viewer',
                'icon' => 'bi bi-badge-3d',
                'route' => 'skin3d.admin.*',
                'items' => $items,
            ],
        ];
    }

    /**
     * User navigation routes.
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
