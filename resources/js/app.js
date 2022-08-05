import './bootstrap';
import Vue from 'vue';

Vue.component('home', require('./pages/Home').default);

const app = new Vue({
    el: '#app',
    mounted() {}
})
