<?php

namespace Azuriom\Plugin\Skin3d\Controllers;

use Azuriom\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class Skin3dHomeController extends Controller
{
    /**
     * Show the home plugin page.
     */
    public function index()
    {
        // Read the JSON file to get the current settings
        $filePath = plugin_path('skin3d/assets/json/settings.json');
        $json = file_get_contents($filePath);
        $data = json_decode($json, true);

        $phrase = $data['phrase'] ?? 'Welcome to Skin3D!';
        $service = $data['service'] ?? 'premium';
        $showPhrase = $data['showPhrase'] ?? true;
        $showButtons = $data['showButtons'] ?? true;
        $background = $data['background'];
        $bgmode = $data['backgroundMode'];
        if (Auth::check()) {
            $phrase = str_replace(':name:', Auth::user()->name, $phrase);
        }

        function transformBackgroundPath($background)
        {

            $transformedBackground = str_replace('public/', 'storage/', $background);


            return $transformedBackground;
        }
        $newBackground = transformBackgroundPath($background);

        // Pass the phrase, service, and options to the view
        return view('skin3d::index', [
            'phrase' => $phrase,
            'service' => $service,
            'showPhrase' => $showPhrase,
            'showButtons' => $showButtons,
            'bgmode' => $bgmode,
            'background' => $newBackground,
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
