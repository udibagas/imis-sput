
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// import datetime from 'vuejs-datetimepicker';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));

// Vue.component('vue-dd', require('./components/Dd.vue'));
// Vue.component('vue-card', require('./components/Card.vue'));
Vue.component('daily-check-setting', require('./components/DailyCheckSetting.vue'));
