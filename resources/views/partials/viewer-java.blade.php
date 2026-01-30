{{-- Minecraft Java Edition Skin Viewer --}}
<div class="col-md-6 d-flex justify-content-center align-items-center canvas-container">
    <canvas id="skin_container" @if($background == null)class="border-skin" @endif style="cursor: grab; background-size:cover;"></canvas>
</div>

@push('scripts')
    <script src="{{ plugin_asset('skin3d', 'js/skinview3d.bundle.min.js')}}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let skinUrl, userName;
            const canvas = document.getElementById("skin_container");
            
            @auth
                skinUrl = "{{ $service === 'premium' ? 'https://mc-heads.net/skin/' . Auth::user()->name : url('api/skin-api/skins/' . Auth::user()->name) }}";
                userName = "{{ Auth::user()->name }}";
            @else
                skinUrl = "{{ plugin_asset('skin3d', 'img/steve.png') }}";
                userName = "Steve";
            @endauth
            
            initializeSkinViewer();

            function initializeSkinViewer() {
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
                        if (textCol) {
                            if (img.width > maxCanvasWidth) {
                                textCol.classList.add('force-below');
                            } else {
                                textCol.classList.remove('force-below');
                            }
                        }
                    };
                }

                @if($background)
                if ("{{ $bgmode }}" === 'background') {
                    let img = new Image();
                    img.src = "{{ url($background) }}";
                    canvas.style.backgroundImage = `url('${img.src}')`;
                    adjustCanvasSize(img);
                } else {
                    skinViewer.loadPanorama("{{ url($background) }}");
                }
                @endif

                const pauseButton = document.getElementById("pauseButton");
                if (pauseButton) {
                    pauseButton.addEventListener("click", function () {
                        skinViewer.animation.paused = !skinViewer.animation.paused;
                        this.textContent = skinViewer.animation.paused
                            ? "{{ trans('skin3d::messages.resume_animation') }}"
                            : "{{ trans('skin3d::messages.pause_animation') }}";
                    });
                }
            }
        });
    </script>
@endpush
