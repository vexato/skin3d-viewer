@extends('admin.layouts.admin')

@section('title', trans('skin3d::messages.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="mt-4">
                <h5>{{ trans('skin3d::messages.how_to_use') }}</h5>

                <ul class="list-group">
                    <li class="list-group-item">
                        <strong>{{ trans('skin3d::messages.instruction') }}</strong> =>
                        <a href="{{ url('skin3d')}}" target="_blank">
                            {{ url('skin3d')}}
                        </a>
                    </li>
                </ul>

                <form action="{{ route('skin3d.admin.update') }}" method="POST">
                    @csrf
                    <div class="form-group mt-4">
                        <label for="service">{{ trans('skin3d::messages.choose_service') }}</label>
                        <select class="form-control" id="service" name="service">
                            <option value="premium" {{ old('service', $currentService) == 'premium' ? 'selected' : '' }}>Premium</option>
                            @plugin('skin-api')
                            <option value="skin_api" {{ old('service', $currentService) == 'skin_api' ? 'selected' : '' }}>Skin API</option>
                            @endplugin
                        </select>
                    </div>
                    @if($currentService === 'premium')

                    <div class="form-check mt-4">
                        <input type="checkbox" class="form-check-input" id="activeCapes" name="activeCapes" {{ old('activeCapes', $activeCapes) ? 'checked' : '' }}>
                        <label class="form-check-label" for="activeCapes">{{ trans('skin3d::admin.capes') }}</label>
                    </div>
                    @endif
                    <div class="form-group mt-4">
                        <label for="phrase">{{ trans('skin3d::messages.phrase') }}</label>
                        <input type="text" class="form-control" id="phrase" placeholder="{{ trans('skin3d::messages.welcome_message') }}" name="phrase" value="{{ old('phrase', $currentPhrase) }}">
                        <ul class="list-group mt-2">
                            <li class="list-group-item">
                                <strong>placeholder: => </strong>
                                <code> :name: </code>
                            </li>
                        </ul>
                    </div>
                    <div class="form-check mt-4">
                        <input type="checkbox" class="form-check-input" id="showPhrase" name="showPhrase" {{ old('showPhrase', $showPhrase) ? 'checked' : '' }}>
                        <label class="form-check-label" for="showPhrase">{{ trans('skin3d::messages.show_phrase') }}</label>
                    </div>
                    <div class="form-check mt-4">
                        <input type="checkbox" class="form-check-input" id="showButtons" name="showButtons" {{ old('showButtons', $showButtons) ? 'checked' : '' }}>
                        <label class="form-check-label" for="showButtons">{{ trans('skin3d::messages.show_buttons') }}</label>
                    </div>

                    <div class="form-group mt-4">
                        <label for="background">{{ trans('skin3d::messages.choose_background') }}</label>
                        <div class="input-group mb-3">
                        <a class="btn btn-outline-success" href="{{ route('admin.images.create') }}" target="_blank" rel="noopener noreferrer">
                            <i class="bi bi-upload"></i>
                        </a>
                        <select class="form-control" id="background" name="background">
                            <option value="" {{ old('background', $currentBackground) == '' ? 'selected' : '' }}>{{ trans('skin3d::messages.no_background') }}</option>
                            @foreach($uploadedImages as $image)
                                <option value="{{ $image }}" {{ old('background', $currentBackground) == $image ? 'selected' : '' }}>{{ basename($image) }}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <label for="backgroundMode">{{ trans('skin3d::messages.choose_bg_mod') }}</label>
                        <select class="form-control" id="backgroundMode" name="backgroundMode">
                            <option value="background" {{ old('backgroundMode', $currentBackgroundMode) == 'background' ? 'selected' : '' }}>Background</option>
                            <option value="panorama" {{ old('backgroundMode', $currentBackgroundMode) == 'panorama' ? 'selected' : '' }}>Panorama</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary mt-2">{{ trans('skin3d::messages.save') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
