
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.echarts = require('echarts');
window.Vue = require('vue');

Vue.filter('formatNumber', function(v) {
    if (!v) {
        return 0;
    }

    return parseFloat(v)
        .toFixed(0)
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
});

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
            vm.$emit('input', this.value);
        });
    },
    destroyed: function () {
        $(this.$el).off().datetimepicker('destroy');
    }
});

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

        $(this.$el).datepicker({
            format:'yyyy-mm-dd',
            autoclose:true,
            todayHighlight: true
        })
        .val(this.value)
        .trigger('change')
        .on('change', function (e) {
            vm.$emit('input', this.value);
        });
    },
    destroyed: function () {
        $(this.$el).off().datepicker('destroy');
    }
});

Vue.component('colorpicker', {
    props: ['value'],
    watch: {
        value: function (value) {
            $(this.$el).val(value).trigger('change');
        },
    },
    template: '<input type="text" class="form-control" data-format="hex">',
    mounted: function () {
        var vm = this;

        $(this.$el).colorpicker()
        .val(this.value)
        .trigger('change')
        .on('changeColor', function (e) {
            vm.$emit('input', this.value);
        });
    },
    destroyed: function () {
        $(this.$el).off().colorpicker('destroy');
    }
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('vue-dd', require('./components/Dd.vue'));
// Vue.component('vue-card', require('./components/Card.vue'));

// Vue.component('stock', require('./components/Stock.vue'));
// Vue.component('water-level', require('./components/WaterLevel.vue'));
Vue.component('daily-check-setting', require('./components/DailyCheckSetting.vue'));
Vue.component('operation-dashboard', require('./components/OperationDashboard.vue'));
Vue.component('stock-dumping-summary', require('./components/StockDumpingSummary.vue'));
Vue.component('material-stock-summary', require('./components/MaterialStockSummary.vue'));
Vue.component('port-activity-summary', require('./components/PortActivitySummary.vue'));
Vue.component('stock-dumping-chart', require('./components/StockDumpingChart.vue'));
Vue.component('ritase-tonase', require('./components/RitaseTonase.vue'));
Vue.component('export-form', require('./components/ExportForm.vue'));
Vue.component('active-barging', require('./components/ActiveBarging.vue'));
Vue.component('productivity', require('./components/Productivity.vue'));
Vue.component('jetty', require('./components/Jetty.vue'));
