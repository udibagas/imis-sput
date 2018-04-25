$('ul.nav > li.active')
    .parent().parent().addClass('active')
    .parent().parent().addClass('active');

$(document).ready(function() {
    // belum jalan
    // $('select').css('width', '100%').select2();
    $('.datetime-picker').datetimepicker();
});

toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}

var block = function(el) {
    $(el).block({
        message: '',
        css: {
            border: 'none',
            opacity: .5,
            width: '50%'
        },
        overlayCSS: {backgroundColor: '#FFF'}
    });

    $(el).addClass('reloading');
};

var unblock = function(el) {
    setTimeout(function () {
        $(el).unblock();
        $(el).removeClass('reloading');
    }, 100);
};

Vue.use(vueSelect2);
