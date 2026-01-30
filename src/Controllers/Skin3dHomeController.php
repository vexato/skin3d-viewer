<?php

namespace Azuriom\Plugin\Skin3d\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Skin3d\Traits\SettingsTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class Skin3dHomeController extends Controller
{
    use SettingsTrait;

    /**
     * Show the home plugin page.
     */
    public function index()
    {
        $data = $this->getSettings();
        $isBedrockUser = $this->isBedrockUser();
        $isHytaleGame = $this->isHytaleGame();

        $phrase = $data->phrase ?? 'Welcome to Skin3D!';
        $service = $data->service ?? 'premium';
        $showPhrase = $data->showPhrase ?? true;
        $showButtons = $data->showButtons ?? true;
        $background = $data->background;
        $bgmode = $data->backgroundMode;
        $actiCapes = $data->activeCapes ?? true;
        $customCapesApi = $data->custom_capes_api;

        $pseudo = 'defaultPseudo';
        
        if (Auth::check()) {
            $phrase = str_replace(':name:', Auth::user()->name, $phrase);
            $pseudo = Auth::user()->name;
        }

        $imageUrl = null;
        $hytaleGlbUrl = null;
        $hytaleSkinData = null;
        
        // Hytale specific logic
        if ($isHytaleGame && Auth::check()) {
            $profileApiUrl = "https://crafthead.net/hytale/profile/{$pseudo}";
            $response = Http::get($profileApiUrl);
            
            if ($response->successful()) {
                $profileData = $response->json();
                if (isset($profileData['skin'])) {
                    $hytaleSkinData = $profileData['skin'];
                    // Encode the skin recipe to base64url
                    $skinJson = json_encode($profileData['skin']);
                    $base64Recipe = rtrim(strtr(base64_encode($skinJson), '+/', '-_'), '=');
                    $hytaleGlbUrl = "https://hytlskins.com/skin/recipe?recipe={$base64Recipe}";
                }
            }
        }
        
        // Minecraft cape logic (only for non-Hytale)
        if (!$isHytaleGame) {
            if ($service == 'premium' && $actiCapes && !$isBedrockUser) {
                $apiUrl = "https://api.capes.dev/load/{$pseudo}/minecraft";
                $response = Http::get($apiUrl);

                if ($response->successful()) {
                    $apiData = $response->json();
                    $imageUrl = $apiData['imageUrl'] ?? null;
                }
            }
            
            if ($service == 'skin_api' && $actiCapes && !$isBedrockUser) {
                $imageUrl = str_replace(':pseudo:', $pseudo, $customCapesApi);
            }
        }

        $newBackground = $this->transformBackgroundPath($background);

        // Determine game type for view selection
        $gameType = 'java'; // default
        if ($isHytaleGame) {
            $gameType = 'hytale';
        } elseif ($isBedrockUser) {
            $gameType = 'bedrock';
        }

        return view('skin3d::index', [
            'phrase' => $phrase,
            'service' => $service,
            'showPhrase' => $showPhrase,
            'showButtons' => $showButtons,
            'bgmode' => $bgmode,
            'background' => $newBackground,
            'actiCapes' => $actiCapes,
            'imageUrl' => $imageUrl,
            'gameType' => $gameType,
            'hytaleGlbUrl' => $hytaleGlbUrl,
        ]);
    }

    /**
     * Show 3D model API view.
     */
    public function show3DApi($pseudo, $width, $height, string $skinUrl)
    {
        return response()->view('skin3d::3d-api', compact('pseudo', 'width', 'height', 'skinUrl'));
    }

    /**
     * Show 3D model for premium skins.
     */
    public function show3DModelPremium($pseudo, $width = 300, $height = 200)
    {
        $skinUrl = "https://mc-heads.net/skin/{$pseudo}";
        return response()->view('skin3d::3d-api', compact('pseudo', 'width', 'height', 'skinUrl'));
    }

    /**
     * Show 3D model for skin-api skins.
     */
    public function show3D($pseudo, $width = 300, $height = 200)
    {
        $skinUrl = url('api/skin-api/skins/' . $pseudo);
        return response()->view('skin3d::3d-api', compact('pseudo', 'width', 'height', 'skinUrl'));
    }
}
