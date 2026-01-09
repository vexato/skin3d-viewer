<?php

namespace Azuriom\Plugin\Skin3d\Traits;

use Azuriom\Plugin\Skin3d\Models\Skin3d;
use Illuminate\Support\Facades\Cache;

trait SettingsTrait
{
    /**
     * Get plugin settings with caching.
     */
    protected function getSettings(): Skin3d
    {
        return Cache::remember('skin3d.settings', 3600, function () {
            $settings = Skin3d::first();

            if (!$settings) {
                $settings = Skin3d::create([
                    'service' => 'premium',
                    'phrase' => '',
                    'background' => '',
                    'backgroundMode' => 'background',
                    'showPhrase' => true,
                    'showButtons' => true,
                    'activeCapes' => true,
                    'custom_capes_api' => null,
                ]);
            }

            return $settings;
        });
    }

    /**
     * Clear settings cache (call after update).
     */
    protected function clearSettingsCache(): void
    {
        Cache::forget('skin3d.settings');
    }

    /**
     * Check if current game is Bedrock edition.
     */
    protected function isBedrockUser(): bool
    {
        return game()->id() === 'mc-bedrock';
    }

    /**
     * Transform background path from public/ to storage/.
     */
    protected function transformBackgroundPath(?string $background): ?string
    {
        if (!$background) {
            return null;
        }
        return str_replace('public/', 'storage/', $background);
    }
}
