@extends('layouts.app')

@section('title', 'skin3d')

@section('content')
@push('styles')
    <link href="{{ plugin_asset('skin3d', 'css/style.css') }}" rel="stylesheet"/>
@endpush

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 d-flex justify-content-center align-items-center">
            <canvas id="skin_container" style="cursor: grab;"></canvas>
        </div>
        <div class="col-md-6 text-center align-self-center">
            <div class="card">
                <div class="card-body">
                    <h3 class="mb-4">{{ trans('skin3d::messages.welcome_message', ['name' => Auth::user()->name]) }}</h3>
                    <a href="{{ env('APP_URL') }}/skin-api" class="btn btn-primary">{{ trans('skin3d::messages.change_skin') }}</a>
                    <button id="pauseButton" class="btn btn-secondary">{{ trans('skin3d::messages.pause_animation') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/skinview3d@3.0.1/bundles/skinview3d.bundle.min.js"></script>
<script>
    let skinViewer = new skinview3d.SkinViewer({
        canvas: document.getElementById("skin_container"),
        width: 300,
        height: 600,
        skin: "{{ env('APP_URL') }}/api/skin-api/skins/{{ Auth::user()->name }}"
    });
    skinViewer.zoom = 0.5;
    skinViewer.animation = new skinview3d.WalkingAnimation();
    skinViewer.fov = 70;
   
    
    skinViewer.nameTag = "{{ Auth::user()->name }}";

    
    document.getElementById("pauseButton").addEventListener("click", function() {
        skinViewer.animation.paused = !skinViewer.animation.paused;
        this.textContent = skinViewer.animation.paused ? "{{ trans('plugin::messages.resume_animation') }}" : "{{ trans('plugin::messages.pause_animation') }}";
    });
</script>

@endsection
