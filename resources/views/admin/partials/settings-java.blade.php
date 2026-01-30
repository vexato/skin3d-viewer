{{-- Admin Settings Partial for Minecraft Java Edition --}}

<!-- Service Selection -->
<div class="card mb-4 shadow-sm">
    <div class="card-header bg-primary text-white">
        <strong>{{ trans('skin3d::messages.choose_service') }}</strong>
    </div>
    <div class="card-body">
        <select class="form-select" id="service" name="service" aria-label="Service Selection">
            <option value="premium" {{ old('service', $currentService) == 'premium' ? 'selected' : '' }}>Premium</option>
            @plugin('skin-api')
            <option value="skin_api" {{ old('service', $currentService) == 'skin_api' ? 'selected' : '' }}>Skin API</option>
            @endplugin
        </select>
    </div>
</div>

<!-- Capes Options -->
<div class="form-check form-switch mb-4">
    <input type="checkbox" class="form-check-input" id="activeCapes" name="activeCapes" {{ old('activeCapes', $activeCapes) ? 'checked' : '' }} onchange="toggleCustomCapesForm()">
    <label class="form-check-label" for="activeCapes">{{ trans('skin3d::admin.capes') }}</label>
</div>

<!-- Custom Capes (only for Skin API) -->
@if($currentService === 'skin_api')
    <div id="customCapesForm" style="{{ $activeCapes ? '' : 'display: none;' }}">
        <div class="form-floating mb-4">
            <input type="text" class="form-control" id="customCapesApi" name="customCapesApi" value="{{ old('customCapesApi', $customCapesApi) }}" placeholder="Custom Capes API">
            <label for="customCapesApi">Custom Capes API</label>
            <small class="text-muted d-block mt-2">
                <i class="bi bi-info-circle"></i> Placeholder: <code>:pseudo:</code><br>
                🤡 you can use : <code>{{ url('assets/plugins/skin3d/img/Rickroll.gif') }}</code>
            </small>
        </div>
    </div>
@endif

<!-- Background Mode -->
<div class="form-floating mb-4">
    <select class="form-select" id="backgroundMode" name="backgroundMode">
        <option value="background" {{ old('backgroundMode', $currentBackgroundMode) == 'background' ? 'selected' : '' }}>Background</option>
        <option value="panorama" {{ old('backgroundMode', $currentBackgroundMode) == 'panorama' ? 'selected' : '' }}>Panorama</option>
    </select>
    <label for="backgroundMode">{{ trans('skin3d::messages.choose_bg_mod') }}</label>
</div>
