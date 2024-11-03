@extends('layouts.app')

@section('title', 'skin3d')

@push('styles')
    <link href="{{ plugin_asset('skin3d', 'css/style.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 d-flex justify-content-center align-items-center">
            <canvas id="skin_container" @if($background == null)class="border-skin" @endif style="cursor: grab; background-size:cover;"></canvas>
        </div>

        @if($showPhrase || $showButtons)
        <div class="col-md-6 text-center align-self-center">
            <div class="card">
                <div class="card-body">
                    @auth
                        @if($showPhrase)
                            <h3 class="mb-4">{{ $phrase }}</h3>
                        @endif
                        @if($showButtons)
                            <a href="{{ url('skin-api')}}" class="btn btn-primary">{{ trans('skin3d::messages.change_skin') }}</a>
                            <button id="pauseButton" class="btn btn-secondary">{{ trans('skin3d::messages.pause_animation') }}</button>
                        @endif
                    @else
                        @if($showPhrase)
                            <h3 class="mb-4">{{ trans('skin3d::messages.noauth', ['name' => 'Steve']) }}</h3>
                        @endif
                        @if($showButtons)
                            <a href="{{ url('user/login')}}" class="btn btn-primary">{{ trans('skin3d::messages.login') }}</a>
                            <a href="{{ url('user/register')}}" class="btn btn-primary">{{ trans('skin3d::messages.register') }}</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ plugin_asset('skin3d', 'js/skinview3d.bundle.min.js')}}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let skinUrl, userName;
        const canvas = document.getElementById("skin_container");

        @auth
            skinUrl = "{{ $service === 'premium' ? 'https://mineskin.eu/skin/' . Auth::user()->name : url('api/skin-api/skins/' . Auth::user()->name) }}";
            userName = "{{ Auth::user()->name }}";
        @else
            skinUrl = "{{ plugin_asset('skin3d', 'img/steve.png') }}";
            userName = "Steve";
        @endauth

        let skinViewer = new skinview3d.SkinViewer({
            canvas: canvas,
            width: 300,
            height: 600,
            skin: skinUrl,
            zoom: 0.5,
            fov: 70,
            nameTag: userName

        });

        @if ($actiCapes and $service === 'premium')
            skinViewer.loadCape("{{ $imageUrl }}");
        @endif

        skinViewer.animation = new skinview3d.WalkingAnimation();

        function adjustCanvasSize(img) {
            img.onload = function () {
                let maxCanvasWidth = canvas.parentElement.clientWidth;
                let newWidth = Math.min(img.width, maxCanvasWidth);
                canvas.width = newWidth;
                canvas.height = img.height * (newWidth / img.width);
                skinViewer.width = canvas.width;
                skinViewer.height = canvas.height;

                const textCol = document.querySelector('.col-md-6.text-center');
                if (img.width > maxCanvasWidth) {
                    textCol.classList.add('force-below');
                } else {
                    textCol.classList.remove('force-below');
                }
            };
        }

        if ("{{ $bgmode }}" === 'background') {
            let img = new Image();
            img.src = "{{ url($background) }}";
            canvas.style.backgroundImage = `url('${img.src}')`;
            adjustCanvasSize(img);
        } else {
            skinViewer.loadPanorama("{{ url($background) }}");
        }

        const pauseButton = document.getElementById("pauseButton");
        if (pauseButton) {
            pauseButton.addEventListener("click", function () {
                skinViewer.animation.paused = !skinViewer.animation.paused;
                this.textContent = skinViewer.animation.paused
                    ? "{{ trans('skin3d::messages.resume_animation') }}"
                    : "{{ trans('skin3d::messages.pause_animation') }}";
            });
        }
    });
</script>
@endpush
