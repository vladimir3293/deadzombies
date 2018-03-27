(function ($, undefined) {
    $(function () {

        $('.nav-categoriess > a').click(function (event) {
            event.preventDefault();
            $('.nav-categoriess ul').slideToggle("slow");
        });

        $('.nav-categories-link').click(function (event) {
            event.preventDefault();
            $('.nav-categories ul').slideToggle("slow");
        });
    });
})(jQuery);
