$(function () {
    $(".js-datepicker").datepicker({
        firstDay: 1,
        dateFormat: "yy-mm-dd"
    })

    $(".js-timepicker").timepicker({
        timeFormat: 'HH:mm',
        interval: 30,
        dynamic: true,
        dropdown: true,
        scrollbar: true
    });
});