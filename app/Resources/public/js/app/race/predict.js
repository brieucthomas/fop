require(['jquery', 'sortable'], function ($, Sortable) {

    var form = $('[name=prediction]');
    var list = $('#list-teams');
    var limit = form.find('select').length;

    form
        .find('.form-group:first')
            .addClass('no-sr-only')
            .end()
        .find('option:selected').each(function() {
            list.append($('<li>').data('id', this.value).append(this.text));
        });

    list.sortable().bind('sortupdate', function(e, ui) {
        form.find('select').each(function(index, el){
            var id = list.find('> li').eq(index).data('id');
            $(this).val(id);
        });

        updateList(list, limit);
    });

    updateList(list, limit);
});


function updateList(list, limit)
{
    list.find('> li').removeClass('bg-success').slice(0, limit).addClass('bg-success');
}

