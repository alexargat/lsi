$(document).ready( () => {

    $('.datepicker').datepicker({
        dateFormat: "dd.mm.yy"
    });


    $('select').select2({
        placeholder: "Local",
        allowClear: true
    });

});