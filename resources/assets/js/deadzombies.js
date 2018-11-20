window.timeTest = function(){
    var newDate = new Date();
    console.log(newDate);
};
window.requestFullScreen = function (el) {
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
    return false;
};

window.toggleFull = function () {
    // $(window).trigger("iPanel.fullscreen", true);
    var iframe = document.getElementById('game-player');
    // if (iframe) {
    //     var elem = iframe;
    // } else {
    //     var elem = document.body; // Make the body go full screen.
    // }
    var elem = iframe;
    // var isInFullScreen = (elem.fullScreenElement && elem.fullScreenElement !== null) || (elem.mozFullScreen || elem.webkitIsFullScreen);
    requestFullScreen(elem);

    // if (isInFullScreen) {
    //     iPanel.cancelFullScreen(document);
    // } else {
    //     iPanel.requestFullScreen(elem);
    // }
    return false;
};


(function ($, undefined) {

    $(document).ready(function () {
        // console.debug($('#top-block-button'));
        $('#top-block-button').click(function (event) {
            $('.top-block, .right-content, .index-footer').toggleClass('top-block-clicked');
            $('.top-block svg').toggleClass('top-block-click-svg');
            $('body, html').toggleClass('overflow-hidden');
        });

        $('.game-play-click').click(function () {
            $('.game-box-play, .game-box-img').css('display', 'none');
            $('.game-box-source, .game-box-fullscreen').css('display', 'block');

            var game = $('#game-player');
            game.attr('src', game.attr('data-src'));
        });
    });
})(jQuery);
