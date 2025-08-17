<?php

namespace Azuriom\Plugin\Skin3d\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BedrockHelper
{
    public static function getBedrockSkinData($xuid)
    {
        try {
            $apiUrl = "https://starlightskins.lunareclipse.studio/info/user/{$xuid}";
            $response = Http::timeout(10)->get($apiUrl);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['playerUUID'], $data['skinUrl'], $data['skinType'])) {
                    return [
                        'playerUUID' => $data['playerUUID'],
                        'skinUrl' => $data['skinUrl'],
                        'skinType' => $data['skinType'],
                        'skinTextureWidth' => $data['skinTextureWidth'] ?? 64,
                        'skinTextureHeight' => $data['skinTextureHeight'] ?? 64,
                    ];
                }
            }
            
            return null;
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération du skin Bedrock: ' . $e->getMessage());
            return null;
        }
    }
    public static function isBedrockUser($user)
    {
        return game()->id() === 'mc-bedrock';
    }

    public static function getBedrockSkinUrl($user)
    {
        if (!self::isBedrockUser($user)) {
            return null;
        }

        $skinData = self::getBedrockSkinData($user->game_id);
        return $skinData ? $skinData['skinUrl'] : null;
    }


    public static function getDefaultBedrockSkin()
    {
        return plugin_asset('skin3d', 'img/steve.png');
    }
}