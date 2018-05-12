$('ul.nav > li.active')
    .parent().parent().addClass('active')
    .parent().parent().addClass('active');

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

Vue.component('select2', {
    props: ['options', 'value'],
    template: '<select class="form-control"><slot></slot></select>',
    mounted: function () {
        var vm = this

        $(this.$el)
        .css('width', '100%')
        .select2({ data: this.options })
        .val(this.value)
        .trigger('change')
        .on('change', function () {
            vm.$emit('input', this.value)
        })
    },
    watch: {
        value: function (value) {
            $(this.$el).val(value).trigger('change');
        },
        options: function (options) {
            $(this.$el).empty().select2({ data: options });
        }
    },
    destroyed: function () {
        $(this.$el).off().select2('destroy')
    }
});

Vue.component('vue-datetimepicker', {
    props: ['value'],
    watch: {
        value: function (value) {
            $(this.$el).val(value).trigger('change');
        },
    },
    template: '<input type="text" class="form-control">',
    mounted: function () {
        var vm = this;

        $(this.$el).datetimepicker()
        .val(this.value)
        .trigger('change')
        .on('dp.change', function (e) {
            vm.$emit('input', this.value)
        });
    },
    destroyed: function () {
        $(this.$el).off().datetimepicker('destroy');
    }
});

// belum jalan
Vue.component('vue-datepicker', {
    props: ['value'],
    watch: {
        value: function (value) {
            $(this.$el).val(value).trigger('change');
        },
    },
    template: '<input type="text" class="form-control">',
    mounted: function () {
        var vm = this;

        $(this.$el).datepicker()
        .val(this.value)
        .trigger('change')
        .on('dp.change', function (e) {
            vm.$emit('input', this.value)
        });
    },
    destroyed: function () {
        $(this.$el).off().datepicker('destroy');
    }
});
