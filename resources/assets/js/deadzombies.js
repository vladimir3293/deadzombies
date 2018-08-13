

(function ($, undefined) {

    $(document).ready(function () {
        // alert('12');
        // console.debug($('#top-block-button'));

        $('#top-block-button').click(function (event) {
            $('.top-block').toggleClass('top-block-clicked');
            $('.right-content').toggleClass('top-block-clicked');
            $('.index-footer').toggleClass('top-block-clicked');
            $('.top-block svg').toggleClass('top-block-click-svg');

            // $('.wrapper').css('transform', 'translateX(0px)').css('background', 'red');
         // alert('12');
        });


        // $('#menu').click(function (event) {
        //     event.preventDefault();
        //     $('#menu').siblings().slideToggle(150);
        // });
        //
        // $('.nav-categories-link').click(function (event) {
        //     event.preventDefault();
        //     $('.nav-categories ul').slideToggle("slow");
        // });
    });
})(jQuery);
