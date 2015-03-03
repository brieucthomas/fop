require(['jquery', 'tableDnD'], function ($, tableDnD) {

    var $table = $('table#table-prediction'),
        $form = $('form[name=prediction]'),
        $selects = $form.find('select'),
        limit = $selects.length

    $selects.on('change', function () {
        // remove this option to other selects
        updateForm()
        buildTableFromForm()
    })

    function buildTableFromForm() {
        var counter = 1
        // remove all rows
        $table.find('> tbody > tr').remove()
        // generate rows from form
        $form.find('option:selected').each(function (index, option) {
            var values = $(option).text().split(' - ')
            $table.find('> tbody').append(
                $('<tr>')
                    .attr('id', 'team-' + $(option).val())
                    .append($('<td>').text(counter++))
                    .append($('<td>').text(values[1]))
                    .append($('<td>').text(values[2]))
                    .append($('<td>').text(''))
            )
        })
        // complete with other drivers
        $form.find('select:first option').each(function (index, option) {
            if ($table.find('tr#team-' + $(option).val()).length) {
                return; // next option
            }
            var values = $(option).text().split(' - ')
            $table.find('> tbody').append(
                $('<tr>')
                    .attr('id', 'team-' + $(this).val())
                    .append($('<td>').text(counter++))
                    .append($('<td>').text(values[1]))
                    .append($('<td>').text(values[2]))
                    .append($('<td>').text(''))
            )
        })
        // init table
        $table.tableDnD({
            onDragClass: 'dragged',
            onDrop: function (table, row) {
                updateTable()
                updateFormFromTable()
            }
        })
        updateTable()
    }

    function updateTable() {
        // update bg
        $table
            .find('> tbody > tr')
            .removeClass('wrapped')
            .slice(0, limit)
            .addClass('wrapped')

        // update positions
        $table.find('> tbody > tr').each(function (index, row) {
            $(row).find('.predicted-position').text(++index)
        })
    }

    function updateForm() {
        // show all options
        $form.find('option').show()
        // hide selected options
        $form.find('option:selected').each(function (index, option) {
            $form.find('option[value=' + $(option).val() + ']').not(this).hide();
        })
    }

    function updateFormFromTable() {
        // show all options
        $form.find('option').show()
        $table.find('> tbody > tr').each(function(index, row) {
            $form.find('select:eq(' + index + ')').val($(row).attr('id').replace('team-',''))
        })
    }

    updateForm()
    buildTableFromForm()


    $form.addClass('sr-only')
});

