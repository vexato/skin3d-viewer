@extends('layouts.app')

@section('title', 'skin3d')

@push('styles')
    <link href="{{ plugin_asset('skin3d', 'css/style.css') }}" rel="stylesheet"/>
    <style>
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
            {{-- Include the appropriate viewer based on game type --}}
            @if($gameType === 'hytale')
                @include('skin3d::partials.viewer-hytale')
            @elseif($gameType === 'bedrock')
                @include('skin3d::partials.viewer-bedrock')
            @else
                @include('skin3d::partials.viewer-java')
            @endif

            {{-- Sidebar with phrase and buttons (common to all) --}}
            @if($showPhrase || $showButtons)
                <div class="col-md-6 d-flex justify-content-center align-items-center">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            @auth
                                @if($showPhrase)
                                    <h3 class="mb-4">
                                        @if($phrase == null)
                                            {{ str_replace(':name:', Auth::user()->name, __('skin3d::messages.welcome_message')) }}
                                        @else
                                            {{ $phrase }}
                                        @endif
                                    </h3>
                                @endif
                                @if($showButtons)
                                    @if($gameType === 'java' && $service == 'skin_api')
                                        <a href="{{ url('skin-api')}}" class="btn btn-primary">{{ trans('skin3d::messages.change_skin') }}</a>
                                    @endif
                                    @if($gameType !== 'hytale')
                                        <button id="pauseButton" class="btn btn-secondary">{{ trans('skin3d::messages.pause_animation') }}</button>
                                    @endif
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
