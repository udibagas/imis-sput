
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.echarts = require('echarts');
window.Vue = require('vue');

Vue.filter('formatNumber', function(v) {
    return parseFloat(v)
        .toFixed(2)
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('vue-dd', require('./components/Dd.vue'));
// Vue.component('vue-card', require('./components/Card.vue'));
Vue.component('water-level', require('./components/WaterLevel.vue'));
Vue.component('daily-check-setting', require('./components/DailyCheckSetting.vue'));
Vue.component('operation-dashboard', require('./components/OperationDashboard.vue'));
