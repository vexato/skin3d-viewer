<?php

namespace Azuriom\Plugin\Skin3d\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Azuriom\Plugin\Skin3d\Models\Skin3d;

class AdminController extends Controller
{
    /**
     * Obtenir les paramètres depuis la base de données ou créer une nouvelle entrée avec des valeurs par défaut s'il n'existe pas encore de configuration.
     *
     * @return skin3d
     */
    private function getSettings()
    {
        // Chercher les paramètres dans la base de données (ici on prend le premier et unique enregistrement)
        $service = skin3d::first(); // Utilisation correcte du modèle skin3d

        // Si aucune configuration n'existe, en créer une avec les valeurs par défaut
        if (!$service) {
            $service = skin3d::create([ // Utilisation correcte du modèle skin3d
                'service' => 'premium',
                'phrase' => '',
                'background' => '',
                'backgroundMode' => 'background',
                'showPhrase' => true,
                'showButtons' => true,
                'activeCapes' => true,
            ]);
        }

        return $service;
    }

    /**
     * Afficher la page d'administration principale du plugin.
     */
    public function index()
    {
        // Obtenir les paramètres depuis la base de données
        $data = $this->getSettings();

        // Obtenir la liste des images téléchargées
        $uploadedImages = Storage::files('public/img');

        return view('skin3d::admin.index', [
            'currentService' => $data->service,
            'currentPhrase' => $data->phrase,
            'currentBackground' => $data->background,
            'currentBackgroundMode' => $data->backgroundMode,
            'uploadedImages' => $uploadedImages,
            'showPhrase' => $data->showPhrase,
            'showButtons' => $data->showButtons,
            'activeCapes' => $data->activeCapes,
        ]);
    }

    /**
     * Mettre à jour les paramètres dans la base de données.
     */
    public function update(Request $request)
    {
        // Récupérer les entrées du formulaire
        $service = $request->input('service');
        $phrase = $request->input('phrase');
        $background = $request->input('background');
        $backgroundMode = $request->input('backgroundMode', 'background');
        $showPhrase = $request->has('showPhrase');
        $showButtons = $request->has('showButtons');
        $activeCapes = $request->has('activeCapes');

        // Obtenir les paramètres actuels depuis la base de données
        $data = $this->getSettings();

        // Mettre à jour les paramètres
        $data->update([
            'service' => $service,
            'phrase' => $phrase,
            'background' => $background,
            'backgroundMode' => $backgroundMode,
            'showPhrase' => $showPhrase,
            'showButtons' => $showButtons,
            'activeCapes' => $activeCapes,
        ]);

        return redirect()->route('skin3d.admin.index')->with('success', 'Settings updated successfully.');
    }

    /**
     * Afficher la page API du plugin.
     */
    public function api()
    {
        // Obtenir les paramètres
        $data = $this->getSettings();

        return view('skin3d::admin.api', [
            'currentService' => $data->service,
        ]);
    }
}
