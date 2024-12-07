@extends('layouts.app')

@section('title', 'skin3d')

@push('styles')
    <link href="{{ plugin_asset('skin3d', 'css/style.css') }}" rel="stylesheet"/>
    <style>
        /* Ajout de quelques ajustements pour améliorer l'UI */
        .card-body {
            padding: 30px;
            text-align: center;
        }

        .btn-primary {
            width: 100%;
            margin-top: 10px;
        }

        .canvas-container {
            position: relative;
            max-width: 100%;
            overflow: hidden;
            display: flex;
            justify-content: center;
        }

        .force-below {
            margin-top: 20px;
        }

        .btn-secondary {
            width: 100%;
            margin-top: 10px;
        }

        /* Effet au survol du bouton */
        .btn:hover {
            opacity: 0.8;
            transform: scale(1.05);
            transition: all 0.3s ease-in-out;
        }
    </style>
@endpush

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 d-flex justify-content-center align-items-center canvas-container">
                <canvas id="skin_container" @if($background == null)class="border-skin" @endif style="cursor: grab; background-size:cover;"></canvas>
            </div>

            @if($showPhrase || $showButtons)
                <div class="col-md-6 d-flex justify-content-center align-items-center">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            @auth
                                @if($showPhrase)
                                    <h3 class="mb-4">@if($phrase == null){{ str_replace(':name:', Auth::user()->name, __('skin3d::messages.welcome_message')) }}
                                        @else{{ $phrase }}@endif</h3>
                                @endif
                                @if($showButtons)
                                        @if($service == 'skin_api')
                                            <a href="{{ url('skin-api')}}" class="btn btn-primary">{{ trans('skin3d::messages.change_skin') }}</a>
                                        @endif
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

            @if ($actiCapes)
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
