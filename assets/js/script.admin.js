function copyIframeCode1() {
    var iframeCode = `<iframe src="{{ url('skin3d/3d-api/skin-api/PSEUDO') }}" style="border: none; width: 319px; height: 221px;"></iframe>`;
    navigator.clipboard.writeText(iframeCode).then(function() {
        alert('Iframe code copied to clipboard!');
    }, function(err) {
        alert('Failed to copy iframe code: ', err);
    });
}
function copyIframeCode2() {
    var iframe = document.getElementById('iframeCode2');
    var iframeCode = `<iframe src="${iframe.src}" style="border: none; width: 319px; height: 221px;"></iframe>`;

    navigator.clipboard.writeText(iframeCode).then(function() {
        alert('Iframe code copied to clipboard!');
    }, function(err) {
        alert('Failed to copy iframe code: ', err);
    });
}
