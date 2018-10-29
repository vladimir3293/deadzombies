function requestFullScreen (el) {
    // Supports most browsers and their versions.
    var requestMethod = el.requestFullScreen || el.webkitRequestFullScreen || el.mozRequestFullScreen || el.msRequestFullScreen;

    if (requestMethod) { // Native full screen.
        requestMethod.call(el);
    } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
        var wscript = new ActiveXObject("WScript.Shell");
        if (wscript !== null) {
            wscript.SendKeys("{F11}");
        }
    }
    return false
}

function toggleFull() {
    // alert('sdfsdd');

    // $(window).trigger("iPanel.fullscreen", true);
  var elem = document.getElementById('iplayer-game');
    // if (iframe) {
    //     var elem = iframe;
    // } else {
    //     var elem = document.body; // Make the body go full screen.
    // }
    // var elem = iframe;
    // var isInFullScreen = (elem.fullScreenElement && elem.fullScreenElement !== null) || (elem.mozFullScreen || elem.webkitIsFullScreen);
    requestFullScreen(elem);

    // if (isInFullScreen) {
    //     iPanel.cancelFullScreen(document);
    // } else {
    //     iPanel.requestFullScreen(elem);
    // }
     return false;
}