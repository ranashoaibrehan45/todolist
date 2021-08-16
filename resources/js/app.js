require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue';
import VModal from 'vue-js-modal'

import App from './views/App.vue'

Vue.use(VModal)

const app = new Vue({
    el: '#app',
    render: h => h(App)
});
