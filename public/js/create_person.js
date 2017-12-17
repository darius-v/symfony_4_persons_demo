console.log('test'); // does not execute
$( document ).ready(function() {
    $('#person_dateOfBirth').datetimepicker({
        format: 'YYYY-MM-DD'
    });
});