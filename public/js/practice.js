$(function () {
    if ($('#moduleName').val() === 'practice') {
        if ($('#pageName').val() === 'step1') {
            $('form button.step2Action').on('click', function () {
                window.location.href = $(this).data('action');
            });

            $('form button.fakeBuyerNamesAction').on('click', function () {
                var href = $(this).data('action');

                showLoader();
                $.get(href)
                    .done(function (data) {
                        console.log('done');
                    })
                    .fail(function (data) {
                        console.log('fail');
                    })
                    .always(function () {
                        hideLoader();
                    });
            });

            $('form button.importAction').on('click', function () {
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
        }

        if ($('#pageName').val() === 'step2') {
            $(function() {
                $('#tableVehicles').DataTable();
            });
        }
    }
});
