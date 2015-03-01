require(['jquery', 'bootstrap', 'moment'], function ($, twbs, moment) {
    $('[data-toggle="tooltip"], [data-hover="tooltip"]').tooltip();

    $('[data-load="localize"]').each(function(index, node){
        $(node).text(moment.utc($(node).data('date')).local().format($(node).data('format')));
    });
});