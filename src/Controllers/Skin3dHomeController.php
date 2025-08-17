<?php

namespace Azuriom\Plugin\Skin3d\Controllers;

use Azuriom\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Azuriom\Plugin\Skin3d\Models\Skin3d;
use Azuriom\Plugin\Skin3d\Helpers\BedrockHelper;

class Skin3dHomeController extends Controller
{
    /**
     * Show the home plugin page.
     */
    public function index()
    {
        if (!Schema::hasTable('skin3d')) {
            Schema::create('skin3d', function ($table) {
                $table->id();
                $table->string('service');
                $table->string('phrase')->nullable();
                $table->string('background')->nullable();
                $table->string('backgroundMode')->default('background');
                $table->boolean('showPhrase')->default(true);
                $table->boolean('showButtons')->default(true);
                $table->boolean('activeCapes')->default(true);
                $table->timestamps();
            });
        }

        $data = Skin3d::first();

        if (!$data) {
            $data = Skin3d::create([
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

        $phrase = $data->phrase ?? 'Welcome to Skin3D!';
        $service = $data->service ?? 'premium';
        $showPhrase = $data->showPhrase ?? true;
        $showButtons = $data->showButtons ?? true;
        $background = $data->background;
        $bgmode = $data->backgroundMode;
        $actiCapes = $data->activeCapes ?? true;
        $customCapesApi = $data->custom_capes_api;

        if (Auth::check()) {
            $phrase = str_replace(':name:', Auth::user()->name, $phrase);
            $pseudo = Auth::user()->name;
            $user = Auth::user();
        } else {
            $pseudo = 'defaultPseudo';
            $user = null;
        }

        $imageUrl = null;
        $isBedrockUser = game()->id() === 'mc-bedrock';
        
        if ($service == 'premium' && $actiCapes && !$isBedrockUser) {
            $apiUrl = "https://api.capes.dev/load/{$pseudo}/minecraft";
            $response = Http::get($apiUrl);

            if ($response->successful()) {
                $apiData = $response->json();
                $imageUrl = $apiData['imageUrl'] ?? null;
            } else {
                $imageUrl = null;
            }
        }
        if ($service == 'skin_api' && $actiCapes && !$isBedrockUser) {
            $imageUrl = str_replace(':pseudo:', $pseudo, $customCapesApi);
        }

        function transformBackgroundPath($background)
        {
            $transformedBackground = str_replace('public/', 'storage/', $background);
            return $transformedBackground;
        }

        $newBackground = transformBackgroundPath($background);

        return view('skin3d::index', [
            'phrase' => $phrase,
            'service' => $service,
            'showPhrase' => $showPhrase,
            'showButtons' => $showButtons,
            'bgmode' => $bgmode,
            'background' => $newBackground,
            'actiCapes' => $actiCapes,
            'imageUrl' => $imageUrl,
            'isBedrockUser' => $isBedrockUser,
        ]);
    }

    public function show3DModelPremium($pseudo, $width, $height)
    {
        return response()->view('skin3d::3d-model', compact('pseudo', 'width', 'height'));
    }

    public function show3D($pseudo, $width, $height)
    {
        return response()->view('skin3d::3d-skinapi', compact('pseudo', 'width', 'height'));
    }
}
