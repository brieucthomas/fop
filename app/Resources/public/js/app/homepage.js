require(['jquery', 'countdown'], function ($, cd) {
    var node = $('#next-race-remaining-time');
    if (node.length) {
        var format = node.html();
        node
            .countdown(node.data('date'))
            .on('update.countdown', function (event) {
                $(this).html(event.strftime(format));
            });
    }
});