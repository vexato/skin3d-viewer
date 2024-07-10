let skinViewer = new skinview3d.SkinViewer({
    canvas: document.getElementById("skin_container"),
    width: 300,
    height: 600,
    skin: "{{ env('APP_URL') }}/api/skin-api/skins/{{ Auth::user()->name }}"
});
skinViewer.zoom = 0.5;
skinViewer.animation = new skinview3d.WalkingAnimation();
skinViewer.fov = 70;
skinViewer.loadCape();

skinViewer.nameTag = "{{ Auth::user()->name }}";


document.getElementById("pauseButton").addEventListener("click", function() {
    skinViewer.animation.paused = !skinViewer.animation.paused;
    this.textContent = skinViewer.animation.paused ? "Reprendre Animation" : "Pause Animation";
});