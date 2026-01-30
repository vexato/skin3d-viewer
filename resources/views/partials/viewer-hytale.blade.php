{{-- Hytale GLB 3D Model Viewer --}}
@push('styles')
    <style>
        .hytale-model-container {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        model-viewer {
            width: 400px;
            height: 600px;
            background: transparent;
            --poster-color: transparent;
        }

        model-viewer.border-skin {
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
        }

        .hytale-loading {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 600px;
            color: #666;
        }

        .hytale-loading .spinner-border {
            width: 3rem;
            height: 3rem;
            margin-bottom: 1rem;
        }

        .hytale-error {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 400px;
            color: #dc3545;
            text-align: center;
            padding: 20px;
        }

        .hytale-error i {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
    </style>
@endpush

<div class="col-md-6 d-flex justify-content-center align-items-center canvas-container">
    @auth
        @if($hytaleGlbUrl)
            <model-viewer
                id="hytale_model"
                src="{{ $hytaleGlbUrl }}"
                alt="Hytale character model"
                auto-rotate
                camera-controls
                touch-action="pan-y"
                interaction-prompt="auto"
                shadow-intensity="1"
                exposure="1"
                camera-orbit="0deg 75deg 20m"
                min-camera-orbit="auto auto 2m"
                max-camera-orbit="auto auto 45m"
                @if($background == null)class="border-skin"@endif
                @if($background)style="background-image: url('{{ url($background) }}'); background-size: cover;"@endif
            >
                <div class="hytale-loading" slot="poster">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <span>{{ trans('skin3d::messages.loading_model') }}</span>
                </div>
            </model-viewer>
        @else
            <div class="hytale-error">
                <i class="bi bi-exclamation-triangle"></i>
                <h5>{{ trans('skin3d::messages.hytale_no_skin') }}</h5>
                <p class="text-muted">{{ trans('skin3d::messages.hytale_no_skin_desc') }}</p>
            </div>
        @endif
    @else
        <div class="hytale-error">
            <i class="bi bi-person-x"></i>
            <h5>{{ trans('skin3d::messages.noauth') }}</h5>
        </div>
    @endauth
</div>

@push('scripts')
    <script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const modelViewer = document.getElementById('hytale_model');
            
            if (modelViewer) {
                modelViewer.addEventListener('error', function(event) {
                    console.error('Model loading error:', event.detail);
                    modelViewer.outerHTML = `
                        <div class="hytale-error">
                            <i class="bi bi-exclamation-triangle"></i>
                            <h5>{{ trans('skin3d::messages.skin_load_error') }}</h5>
                        </div>
                    `;
                });

                modelViewer.addEventListener('load', function() {
                    console.log('Hytale model loaded successfully');
                });
            }
        });
    </script>
@endpush
