<?php

namespace Azuriom\Plugin\Skin3d\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

        $currentService = $data['service'] ?? 'premium'; // Default to 'premium' if not set
        $currentPhrase = $data['phrase'] ?? ''; // Default to empty string if not set

        // Pass the current values to the view
        return view('skin3d::admin.index', [
            'currentService' => $currentService,
            'currentPhrase' => $currentPhrase,
        ]);
    }

    /**
     * Update the settings in the JSON file.
     */
    public function update(Request $request)
    {
        $service = $request->input('service');
        $phrase = $request->input('phrase');

        $filePath = plugin_path('skin3d/assets/json/settings.json');
        $json = file_get_contents($filePath);
        $data = json_decode($json, true);

        $data['service'] = $service;
        $data['phrase'] = $phrase;

        file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));

        // Redirect to the correct route
        return redirect()->route('skin3d.admin.index')->with('success', 'Settings updated successfully.');
    }
}

