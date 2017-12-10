$(function () {
    $('form button').on('click', function () {
        var href = $('form').attr('action');
        var csvUrl = $('#inputUrl').val();

// console.log('href: ' + href + '\n csvUrl: ' + csvUrl);

        var formData = {
            'csvUrl': csvUrl
        };

        console.log('show loader');
        $.post(href, formData)
            .done(function (data) {
                console.log('done');
                console.log(data);
            }).fail(function (data) {
                console.log('fajl miserably');
            }).always(function () {
                console.log('hide loader');
            });
    });

});
