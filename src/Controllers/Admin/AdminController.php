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


    public function index()
    {
        $data = $this->getSettings();
        $isBedrockUser = game()->id() === 'mc-bedrock';

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

        if (game()->id() !== 'mc-bedrock') {
            $updateData['service'] = $request->input('service');
            $updateData['activeCapes'] = $request->has('activeCapes');
            $updateData['custom_capes_api'] = $request->input('customCapesApi');
        }

        $data->update($updateData);

        return redirect()->route('skin3d.admin.index')->with('success', 'Settings updated successfully.');
    }

    public function api()
    {
        $data = $this->getSettings();

        return view('skin3d::admin.api', [
            'currentService' => $data->service,
        ]);
    }
}
