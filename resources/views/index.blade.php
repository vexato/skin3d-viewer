@extends('layouts.app')

@section('title', 'skin3dviewer')

@section('content')
@push('styles')
    <link href="{{ plugin_asset('skin3dviewer', 'css/style.css') }}" rel="stylesheet"/>
@endpush

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 d-flex justify-content-center align-items-center">
            <canvas id="skin_container" style="cursor: grab;"></canvas>
        </div>
        <div class="col-md-6 text-center align-self-center">
            <div class="card">
                <div class="card-body">
                    @auth
                    <h3 class="mb-4">{{ trans('skin3dviewer::messages.welcome_message', ['name' => Auth::user()->name]) }}</h3>
                    <a href="{{ url('skin-api')}}" class="btn btn-primary">{{ trans('skin3dviewer::messages.change_skin') }}</a>
                    <button id="pauseButton" class="btn btn-secondary">{{ trans('skin3dviewer::messages.pause_animation') }}</button>
                    @else
                    <h3 class="mb-4">{{ trans('skin3dviewer::messages.noauth', ['name' => 'Steve']) }}</h3>

                    <a href="{{ url('user/login')}}" class="btn btn-primary">{{ trans('skin3dviewer::messages.login') }}</a>
                    
                    <a href="{{ url('user/register')}}" class="btn btn-primary">{{ trans('skin3dviewer::messages.register') }}</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/skinview3d@3.0.1/bundles/skinview3d.bundle.min.js"></script>
<script>
    let skinUrl, userName, authyes;

    @auth
        skinUrl = "{{ url('api/skin-api/skins/' . Auth::user()->name) }}";
        userName = "{{ Auth::user()->name }}";
    @else
        skinUrl = "{{ plugin_asset('skin3dviewer', 'img/steve.png') }}"; // Utilisation de plugin_asset pour l'image de Steve
        userName = "Steve";
    @endauth

    let skinViewer = new skinview3d.SkinViewer({
        canvas: document.getElementById("skin_container"),
        width: 300,
        height: 600,
        skin: skinUrl
    });
    skinViewer.zoom = 0.5;
    skinViewer.animation = new skinview3d.WalkingAnimation();
    skinViewer.fov = 70;
    skinViewer.nameTag = userName;

    document.getElementById("pauseButton").addEventListener("click", function() {
        skinViewer.animation.paused = !skinViewer.animation.paused;
        this.textContent = skinViewer.animation.paused ? "{{ trans('skin3dviewer::messages.resume_animation') }}" : "{{ trans('skin3dviewer::messages.pause_animation') }}";
    });
</script>

@endsection
