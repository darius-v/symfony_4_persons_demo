$(document).ready(function() {

    var $table = $('table');

    $table.DataTable();

    $table.on('click', '.details-ajax', function (e) {

        e.preventDefault();

        var id = $(this).data('id');

        $.get(baseUrl + '/person/' + id, function (response) {

            var person = response.data;

            $('#modal-full-name').text(person.fullName);
            $('#modal-phone-number').text(person.phoneNumber);

            $("#details-modal").modal();
        });
    })
});
