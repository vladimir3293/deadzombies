(function ($, undefined) {
    $(document).ready(function () {
        console.log('start');
        var client = algoliasearch('TQARMJGO8A', '3690a3214c8934d794287d2d4c28d37f');
        var index = client.initIndex('prod_GAMEDISTRIBUTION');
        // https://www.algolia.com/doc/api-reference/api-methods/browse/?language=php#examples
        var browser = index.browseAll();
        var hits = [];

        browser.on('result', function onResult(content) {
            hits = hits.concat(content.hits);
        });

        browser.on('end', function onEnd() {
            console.log('Finished!');
            console.log('We got %d hits', hits.length);
        });

        browser.on('error', function onError(err) {
            throw err;
        });

        $('#show-game').click(function (event) {
            var game = $('#game-player');
            game.attr('src', game.attr('data-src'));
            // game.css('display', 'block');
            game.toggle();
        // console.log(game);
        });

        $('.nav-categories-link').click(function (event) {
            event.preventDefault();
            $('.nav-categories ul').slideToggle("slow");
        });
    });
})(jQuery);
