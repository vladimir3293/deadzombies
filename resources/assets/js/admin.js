(function ($, undefined) {
    $(function () {
        $('#show-game').click(function (event) {
            var game = $('#game-player');
            game.attr('src', game.attr('data-src'));
            game.css('display', 'block');
            // game.toogle();
        // console.log(game);
        });

        $('.nav-categories-link').click(function (event) {
            event.preventDefault();
            $('.nav-categories ul').slideToggle("slow");
        });
    });
})(jQuery);
