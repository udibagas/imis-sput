$('ul.nav > li.active')
    .parent().parent().addClass('active')
    .parent().parent().addClass('active');

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
