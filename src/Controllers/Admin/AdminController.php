<?php

namespace Azuriom\Plugin\Skin3d\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Schema\Blueprint;
use Azuriom\Plugin\Skin3d\Models\Skin3d;

class AdminController extends Controller
{
    /**
     * Vérifie et met à jour la structure de la table si nécessaire.
     */
    private function ensureTableStructure()
    {
        if (!Schema::hasTable('skin3d')) {
            Schema::create('skin3d', function (Blueprint $table) {
                $table->id();
                $table->string('service');
                $table->string('phrase')->nullable();
                $table->string('background')->nullable();
                $table->string('backgroundMode')->default('background');
                $table->boolean('showPhrase')->default(true);
                $table->boolean('showButtons')->default(true);
                $table->boolean('activeCapes')->default(true);
                $table->string('custom_capes_api')->nullable();
                $table->timestamps();
            });
        } else {
            Schema::table('skin3d', function (Blueprint $table) {
                if (!Schema::hasColumn('skin3d', 'custom_capes_api')) {
                    $table->string('custom_capes_api')->nullable();
                }
            });
        }
    }

    /**
     * Obtenir les paramètres depuis la base de données ou créer une nouvelle entrée avec des valeurs par défaut s'il n'existe pas encore de configuration.
     *
     * @return Skin3d
     */
    private function getSettings()
    {
        $this->ensureTableStructure();

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
                'custom_capes_api' => null,
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
        $isBedrockUser = game()->id() === 'mc-bedrock';

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
            'customCapesApi' => $data->custom_capes_api,
            'isBedrockUser' => $isBedrockUser,
        ]);
    }

    /**
     * Mettre à jour les paramètres dans la base de données.
     */
    public function update(Request $request)
    {
        $data = $this->getSettings();

        $updateData = [
            'phrase' => $request->input('phrase'),
            'background' => $request->input('background'),
            'backgroundMode' => $request->input('backgroundMode', 'background'),
            'showPhrase' => $request->has('showPhrase'),
            'showButtons' => $request->has('showButtons'),
        ];

        // Si ce n'est pas Bedrock, on peut modifier service, capes et custom_capes_api
        if (game()->id() !== 'mc-bedrock') {
            $updateData['service'] = $request->input('service');
            $updateData['activeCapes'] = $request->has('activeCapes');
            $updateData['custom_capes_api'] = $request->input('customCapesApi');
        }

        $data->update($updateData);

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
