<?php

namespace Azuriom\Plugin\Skin3d\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Skin3d\Traits\SettingsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Schema\Blueprint;

class AdminController extends Controller
{
    use SettingsTrait;

    /**
     * Ensure new columns exist (for plugin updates).
     */
    private function ensureColumnsExist(): void
    {
        if (Schema::hasTable('skin3d') && !Schema::hasColumn('skin3d', 'custom_capes_api')) {
            Schema::table('skin3d', function (Blueprint $table) {
                $table->string('custom_capes_api')->nullable();
            });
        }
    }

    public function index()
    {
        $this->ensureColumnsExist();
        $data = $this->getSettings();
        $isBedrockUser = $this->isBedrockUser();

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

        if (!$this->isBedrockUser()) {
            $updateData['service'] = $request->input('service');
            $updateData['activeCapes'] = $request->has('activeCapes');
            $updateData['custom_capes_api'] = $request->input('customCapesApi');
        }

        $data->update($updateData);
        $this->clearSettingsCache();

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
