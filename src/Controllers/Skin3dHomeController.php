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
        $service = $data['service'] ?? 'premium'; // Default to 'premium' if not set

        // Replace ':name:' with the authenticated user's name if they are logged in
        if (Auth::check()) {
            $phrase = str_replace(':name:', Auth::user()->name, $phrase);
        }

        // Pass the phrase and service to the view
        return view('skin3d::index', [
            'phrase' => $phrase,
            'service' => $service
        ]);
    }
}
