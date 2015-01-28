require(['jquery', 'sortable'], function ($, Sortable) {

    var form = $('[name=prediction]'),
        list = $('#list-teams');

    form.find('.form-group:first').addClass('no-sr-only');

    form.find('select').on('change', function () {
        updateListFromForm(list, form);
    });

    list.sortable({
        onDrop: function (item, targetContainer, _super) {
            updateFormFromList(form, list);
        }
    });

    updateListFromForm(list, form);
});

function removeListItems(list) {
    list.find('> li').remove();
}

function updateListFromForm(list, form) {
    var limit = form.find('select').length;

    removeListItems();

    form.find('select').first().find('> option').each(function () {
        appendListItemFromSelect(list, $(this));
    });

    form.find('options:selected').each(function () {
        removeListItemFromSelect(list, $(this));
        prependListItemFromSelect(list, $(this));
    });

    list.find('> li').removeClass('bg-success').slice(0, limit).addClass('bg-success');
}


function updateFormFromList(form, list) {
    form.find('select').each(function (index, el) {
        var id = list.find('> li').eq(index).data('id');
        $(this).val(id);
    });
}

function prependListItemFromSelect(list, select) {
    list.prepend($('<li>').data('id', select.val()).append(select.text()));
}

function appendListItemFromSelect(list, select) {
    list.append($('<li>').data('id', select.val()).append(select.text()));
}

function removeListItemFromSelect(list, select) {
    list.find('li[data-id=' + select.val() + ']').remove();
}