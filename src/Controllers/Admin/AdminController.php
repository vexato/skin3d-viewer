<?php

namespace Azuriom\Plugin\Skin3d\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Azuriom\Plugin\Skin3d\Models\Skin3d;

class AdminController extends Controller
{
    /**
     * Obtenir les paramètres depuis la base de données ou créer une nouvelle entrée avec des valeurs par défaut s'il n'existe pas encore de configuration.
     *
     * @return Skin3d
     */
    private function getSettings()
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

        $service = Skin3d::first();

        if (!$service) {
            $service = Skin3d::create([
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

        $data = $this->getSettings();

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
        $data = $this->getSettings();

        return view('skin3d::admin.api', [
            'currentService' => $data->service,
        ]);
    }
}
