require(['jquery', 'c3'], function ($, c3) {

    c3.generate({
        bindto: '#chart-user-standings',
        data: {
            url: $('#chart-user-standings').data('url'),
            mimeType: 'json'
        }
    });

});