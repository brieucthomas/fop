require(['jquery', 'countdown'], function ($, cd) {
    var node = $('#next-race-countdown');
    if (node.length) {
        var format = node.html();
        node
            .countdown(node.data('end-date'))
            .on('update.countdown', function (event) {
                $(this).html(event.strftime(format));
            })
            .removeClass('hidden');
    }
});