require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue';
import VModal from 'vue-js-modal'

import App from './views/App.vue'

Vue.use(VModal)

axios.defaults.baseURL = 'https://www.localhost.dev/todolist/public';

const app = new Vue({
    el: '#app',
    render: h => h(App)
});
