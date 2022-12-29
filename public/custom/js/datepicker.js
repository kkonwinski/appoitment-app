$( function() {
    $( ".js-datepicker" ).datepicker({
        dateFormat: "yy-mm-dd"
        }
    )
    $(".js-timepicker").timepicker({
        timeFormat: 'HH:mm',
        interval: 10,
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });
} );