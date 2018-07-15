try {
    window.$ = window.jQuery = require('jquery');

    //require('bootstrap-sass');
} catch (e) {}

(function ($, undefined) {
    $(function () {

        $('#menu').click(function (event) {
            event.preventDefault();
            $('#menu').siblings().slideToggle(150);
        });

        $('.nav-categories-link').click(function (event) {
            event.preventDefault();
            $('.nav-categories ul').slideToggle("slow");
        });
    });
})(jQuery);
