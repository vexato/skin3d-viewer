<?php

namespace Azuriom\Plugin\Skin3d\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Show the home admin page of the plugin.
     */
    public function index()
    {
        // Read the JSON file to get the current values
        $filePath = plugin_path('skin3d/assets/json/settings.json');
        $json = file_get_contents($filePath);
        $data = json_decode($json, true);

        $currentService = $data['service'] ?? 'premium';
        $currentPhrase = $data['phrase'] ?? '';
        $currentBackground = $data['background'] ?? '';
        $currentBackgroundMode = $data['backgroundMode'] ?? 'background'; // Added this line
        $showPhrase = $data['showPhrase'] ?? true;
        $showButtons = $data['showButtons'] ?? true;

        // Get a list of uploaded images
        $uploadedImages = Storage::files('public/img');

        return view('skin3d::admin.index', [
            'currentService' => $currentService,
            'currentPhrase' => $currentPhrase,
            'currentBackground' => $currentBackground,
            'currentBackgroundMode' => $currentBackgroundMode, // Added this line
            'uploadedImages' => $uploadedImages,
            'showPhrase' => $showPhrase,
            'showButtons' => $showButtons
        ]);
    }

    /**
     * Update the settings in the JSON file.
     */
    public function update(Request $request)
    {
        $service = $request->input('service');
        $phrase = $request->input('phrase');
        $background = $request->input('background');
        $backgroundMode = $request->input('backgroundMode', 'background'); // Added this line
        $showPhrase = $request->has('showPhrase');
        $showButtons = $request->has('showButtons');

        $filePath = plugin_path('skin3d/assets/json/settings.json');
        $json = file_get_contents($filePath);
        $data = json_decode($json, true);

        $data['service'] = $service;
        $data['phrase'] = $phrase;
        $data['background'] = $background;
        $data['backgroundMode'] = $backgroundMode; // Added this line
        $data['showPhrase'] = $showPhrase;
        $data['showButtons'] = $showButtons;

        file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));

        return redirect()->route('skin3d.admin.index')->with('success', 'Settings updated successfully.');
    }

    public function api()
    {
        $filePath = plugin_path('skin3d/assets/json/settings.json');
        $json = file_get_contents($filePath);
        $data = json_decode($json, true);

        $currentService2 = $data['service'] ?? 'premium';
        return view('skin3d::admin.api', [
            'currentService' => $currentService2,
        ]);
    }
}
