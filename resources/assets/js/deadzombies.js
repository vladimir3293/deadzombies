(function ($, undefined) {

    $(document).ready(function () {

        // alert('12');
        // console.debug($('#top-block-button'));
        $('#top-block-button').click(function (event) {
            $('.top-block, .top-block-slider, .right-content, .index-footer').toggleClass('top-block-clicked');
            $('.top-block svg').toggleClass('top-block-click-svg');
            $('body, html').toggleClass('overflow-hidden');
        });
    });
})(jQuery);
