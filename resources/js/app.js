import './bootstrap';
import Vue from 'vue';
import VModal from 'vue-js-modal'
import 'vue-js-modal/dist/styles.css'


Vue.component('home', require('./pages/Home').default);
Vue.use(VModal, {})

const app = new Vue({
    el: '#app',
    mounted() {}
})
