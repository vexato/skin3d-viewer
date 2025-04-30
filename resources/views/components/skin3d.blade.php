<style>
    @font-face {
        font-family: 'Minecraft';
        src: url({{ plugin_asset('skin3d', 'font/minecraft.woff2') }}) format('woff2');
    }
</style>

<canvas id="skin_container"></canvas>
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
    });
</script>
