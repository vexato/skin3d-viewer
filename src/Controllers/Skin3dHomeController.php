<?php

namespace Azuriom\Plugin\Skin3d\Controllers;

use Azuriom\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Azuriom\Plugin\Skin3d\Models\Skin3d;

class Skin3dHomeController extends Controller
{
    /**
     * Show the home plugin page.
     */
    public function index()
    {
        // Vérifier si la table existe
        if (!Schema::hasTable('skin3d')) {
            // Si la table n'existe pas, créer la table
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

        // défaut
        if (!$data) {
            $data = Skin3d::create([
                'service' => 'premium',
                'phrase' => '',
                'background' => '',
                'backgroundMode' => 'background',
                'showPhrase' => true,
                'showButtons' => true,
                'activeCapes' => true,
            ]);
        }

        // Initialisation des données locales
        $phrase = $data->phrase ?? 'Welcome to Skin3D!';
        $service = $data->service ?? 'premium';
        $showPhrase = $data->showPhrase ?? true;
        $showButtons = $data->showButtons ?? true;
        $background = $data->background;
        $bgmode = $data->backgroundMode;
        $actiCapes = $data->activeCapes ?? true;

        // Si l'utilisateur est authentifié, personnaliser la phrase
        if (Auth::check()) {
            $phrase = str_replace(':name:', Auth::user()->name, $phrase);
            $pseudo = Auth::user()->name;
        } else {
            $pseudo = 'defaultPseudo';
        }

        // Logique pour le service premium
        if ($service == 'premium') {
            $apiUrl = "https://api.capes.dev/load/{$pseudo}/minecraft";
            $response = Http::get($apiUrl);

            if ($response->successful()) {
                $apiData = $response->json();
                $imageUrl = $apiData['imageUrl'] ?? null;
            } else {
                $imageUrl = null;
            }
        } else {
            $imageUrl = null;
        }

        function transformBackgroundPath($background)
        {
            $transformedBackground = str_replace('public/', 'storage/', $background);
            return $transformedBackground;
        }

        $newBackground = transformBackgroundPath($background);

        // Passer les données à la vue
        return view('skin3d::index', [
            'phrase' => $phrase,
            'service' => $service,
            'showPhrase' => $showPhrase,
            'showButtons' => $showButtons,
            'bgmode' => $bgmode,
            'background' => $newBackground,
            'actiCapes' => $actiCapes,
            'imageUrl' => $imageUrl,
        ]);
    }

    public function show3DModelPremium($pseudo)
    {
        return response()->view('skin3d::3d-model', compact('pseudo'));
    }

    public function show3D($pseudo)
    {
        return response()->view('skin3d::3d-skinapi', compact('pseudo'));
    }
}
