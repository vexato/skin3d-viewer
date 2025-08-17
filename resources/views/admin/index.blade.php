@extends('admin.layouts.admin')

@section('title', trans('skin3d::messages.title'))

@section('content')
    <div class="card shadow-lg p-4 mb-5 bg-white rounded">
        <div class="card-body">
            <div class="mt-4">
                @if($isBedrockUser)
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle-fill"></i>
SKIND 3D BEDROCK IS IN BETA, PLEASE REPORT ANY BUGS ON DISCORD.                </div>
                @endif
                <h4 class="mb-3 text-primary"><i class="bi bi-tools"></i> {{ trans('skin3d::messages.how_to_use') }}</h4>

                <!-- Instructions -->
                <div class="alert alert-info d-flex align-items-center">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    <strong>{{ trans('skin3d::messages.instruction') }}</strong>
                    <a href="{{ url('skin3d') }}" target="_blank" class="ms-auto text-primary text-decoration-underline">
                        {{ url('skin3d') }}
                    </a>
                </div>

                <form action="{{ route('skin3d.admin.update') }}" method="POST" class="needs-validation" id="updateForm" novalidate>
                    @csrf

                    <!-- Service Selection -->
                    @if(!$isBedrockUser)
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
                    @endif

                    <!-- Capes Options -->
                    @if(!$isBedrockUser)
                    <div class="form-check form-switch mb-4">
                        <input type="checkbox" class="form-check-input" id="activeCapes" name="activeCapes" {{ old('activeCapes', $activeCapes) ? 'checked' : '' }} onchange="toggleCustomCapesForm()">
                        <label class="form-check-label" for="activeCapes">{{ trans('skin3d::admin.capes') }}</label>
                    </div>
                    @endif

                    <!-- Custom Capes -->
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

                    <!-- Phrase -->
                    <div class="form-floating mb-4">
                        <input type="text" class="form-control" id="phrase" name="phrase" placeholder="{{ trans('skin3d::messages.welcome_message') }}" value="{{ old('phrase', $currentPhrase) }}">
                        <label for="phrase">{{ trans('skin3d::messages.phrase') }}</label>
                        <small class="text-muted d-block mt-2">
                            <i class="bi bi-info-circle"></i> Placeholder: <code>:name:</code>
                        </small>
                    </div>

                    <!-- Additional Options -->
                    <div class="form-check form-switch mb-4">
                        <input type="checkbox" class="form-check-input" id="showPhrase" name="showPhrase" {{ old('showPhrase', $showPhrase) ? 'checked' : '' }}>
                        <label class="form-check-label" for="showPhrase">{{ trans('skin3d::messages.show_phrase') }}</label>
                    </div>
                    <div class="form-check form-switch mb-4">
                        <input type="checkbox" class="form-check-input" id="showButtons" name="showButtons" {{ old('showButtons', $showButtons) ? 'checked' : '' }}>
                        <label class="form-check-label" for="showButtons">{{ trans('skin3d::messages.show_buttons') }}</label>
                    </div>

                    <!-- Background Selection -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <strong>{{ trans('skin3d::messages.choose_background') }}</strong>
                        </div>
                        <div class="card-body">
                            <div class="input-group">
                                <a href="{{ route('admin.images.create') }}" target="_blank" class="btn btn-outline-success" data-bs-toggle="tooltip" title="Upload New Background">
                                    <i class="bi bi-upload"></i>
                                </a>
                                <select class="form-select" id="background" name="background">
                                    <option value="" {{ old('background', $currentBackground) == '' ? 'selected' : '' }}>{{ trans('skin3d::messages.no_background') }}</option>
                                    @foreach($uploadedImages as $image)
                                        <option value="{{ $image }}" {{ old('background', $currentBackground) == $image ? 'selected' : '' }}>{{ basename($image) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Background Mode -->
                    <div class="form-floating mb-4">
                        <select class="form-select" id="backgroundMode" name="backgroundMode">
                            <option value="background" {{ old('backgroundMode', $currentBackgroundMode) == 'background' ? 'selected' : '' }}>Background</option>
                            <option value="panorama" {{ old('backgroundMode', $currentBackgroundMode) == 'panorama' ? 'selected' : '' }}>Panorama</option>
                        </select>
                        <label for="backgroundMode">{{ trans('skin3d::messages.choose_bg_mod') }}</label>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> {{ trans('skin3d::messages.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ plugin_asset('skin3d', 'js/script.admin.js') }}"></script>
    @endpush
@endsection
