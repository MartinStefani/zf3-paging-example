$(function () {
    $('form button.importAction').on('click', function() {
        var href = $(this).data('action');
        var csvUrl = $('#inputUrl').val();

        var formData = {
            'csvUrl': csvUrl
        };

        acktion(href, formData);
    });

    $('form button.parseAction').on('click', function () {
        var href = $('form').attr('action');
        var csvUrl = $('#inputUrl').val();

        var formData = {
            'csvUrl': csvUrl
        };

        acktion(href, formData);
    });

    function acktion(href, formData) {
        showLoader();
        var parsedDataContainer = $('#parsedDataTable');
        parsedDataContainer.hide();

        $.post(href, formData)
            .done(function (data) {
                dataToTable(data);
            }).fail(function (data) {
            console.log('fajl miserably');
        }).always(function () {
            hideLoader();
        });
   }

    function showLoader() {
        $('#loader').show();
    }

    function hideLoader() {
        $('#loader').hide();
    }

    function dataToTable(data) {
        var parsedDataContainer = $('#parsedDataTable');
        parsedDataContainer.hide();

        var table = parsedDataContainer.find('table');
        var thead = table.find('thead');
        var tbody = table.find('tbody');

        // Table Head
        thead.empty();
        $.each(data.HeadRows, function (i, colTitle) {
            var th = $('<th>').text(colTitle);
            thead.append(th);
        });

        // Table Data
        tbody.empty();
        $.each(data.DataRows, function (i, rowData) {
            var tr = $('<tr>');
            $.each(rowData, function (i, rowCell) {
                var td = $('<td>').text(rowCell);
                tr.append(td);
            });
            tbody.append(tr);
        });

        parsedDataContainer.show();
    }
});
