(function ($, undefined) {

    $(document).ready(function () {

        // alert('12');
        // console.debug($('#top-block-button'));
        $('#top-block-button').click(function (event) {
            $('.top-block, .right-content, .index-footer').toggleClass('top-block-clicked');
            $('.top-block svg').toggleClass('top-block-click-svg');
            $('body, html').toggleClass('overflow-hidden');
        });

            $(function () {
                /* set variables locally for increased performance */
                var scroll_timer;
                var displayed = false;
                var $message = $('#message a');
                var $window = $(window);
                var top = $(document.body).children(0).position().top;
                /* react to scroll event on window */
                $window.scroll(function () {
                    window.clearTimeout(scroll_timer);
                    scroll_timer = window.setTimeout(function () {
                        if($window.scrollTop() <= top)
                        {
                            displayed = false;
                            $message.fadeOut(500);
                        }
                        else if(displayed == false)
                        {
                            displayed = true;
                            $message.stop(true, true).show().click(function () { $message.fadeOut(500); });
                        }
                    }, 100);
                });
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
