{{-- Admin Settings Partial for Minecraft Bedrock Edition --}}

<!-- Beta Warning -->
<div class="alert alert-warning d-flex justify-content-between align-items-center mb-4" role="alert">
    <span>{{ trans('skin3d::admin.beta') }}</span>
    <a href="https://discord.gg/Bnpw2awVRV" class="btn btn-secondary ml-2"><i class="bi bi-discord"></i> Discord</a>
</div>

<!-- Background Mode -->
<div class="form-floating mb-4">
    <select class="form-select" id="backgroundMode" name="backgroundMode">
        <option value="background" {{ old('backgroundMode', $currentBackgroundMode) == 'background' ? 'selected' : '' }}>Background</option>
        <option value="panorama" {{ old('backgroundMode', $currentBackgroundMode) == 'panorama' ? 'selected' : '' }}>Panorama</option>
    </select>
    <label for="backgroundMode">{{ trans('skin3d::messages.choose_bg_mod') }}</label>
</div>
