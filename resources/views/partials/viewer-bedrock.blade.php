{{-- Minecraft Bedrock Skin Viewer --}}
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
                const xuid = '{{ Auth::user()->game_id }}' || '2535406248655892';
                
                fetch('https://starlightskins.lunareclipse.studio/info/user/.' + xuid)
                    .then(response => response.json())
                    .then(data => {
                        if (data.skinUrl) {
                            skinUrl = data.skinUrl;
                        } else {
                            skinUrl = "{{ plugin_asset('skin3d', 'img/steve.png') }}";
                        }
                        initializeSkinViewer();
                    })
                    .catch(error => {
                        console.error('Error on Bedrock skin loading:', error);
                        skinUrl = "{{ plugin_asset('skin3d', 'img/steve.png') }}";
                        initializeSkinViewer();
                    });
                userName = "{{ Auth::user()->name }}";
            @else
                skinUrl = "{{ plugin_asset('skin3d', 'img/steve.png') }}";
                userName = "Steve";
                initializeSkinViewer();
            @endauth

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

                skinViewer.animation = new skinview3d.WalkingAnimation();

                @if($background)
                if ("{{ $bgmode }}" === 'background') {
                    let img = new Image();
                    img.src = "{{ url($background) }}";
                    canvas.style.backgroundImage = `url('${img.src}')`;
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
