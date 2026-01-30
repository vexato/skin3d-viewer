{{-- Admin Settings Partial for Minecraft Bedrock Edition --}}

<!-- Background Mode -->
<div class="form-floating mb-4">
    <select class="form-select" id="backgroundMode" name="backgroundMode">
        <option value="background" {{ old('backgroundMode', $currentBackgroundMode) == 'background' ? 'selected' : '' }}>Background</option>
        <option value="panorama" {{ old('backgroundMode', $currentBackgroundMode) == 'panorama' ? 'selected' : '' }}>Panorama</option>
    </select>
    <label for="backgroundMode">{{ trans('skin3d::messages.choose_bg_mod') }}</label>
</div>
