<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modèle 3D pour {{ $pseudo }}</title>
</head>
<body>
<canvas id="skin_container" style="cursor: grabbing"></canvas>
<script src="https://cdn.jsdelivr.net/npm/skinview3d@3.0.1/bundles/skinview3d.bundle.min.js"></script>

<script>
    function getURLParameter(name) {
        return new URLSearchParams(window.location.search).get(name);
    }

    let zoom = getURLParameter('zoom') === 'false';

    let skinViewer = new skinview3d.SkinViewer({
        canvas: document.getElementById("skin_container"),
        width: {{ $width }},
        height: {{ $height }},
        skin: "{{ url('api/skin-api/skins/' . $pseudo) }}"
    });
    if (zoom) {
        skinViewer.controls.enableZoom = false;
    }
</script>
</body>
</html>
