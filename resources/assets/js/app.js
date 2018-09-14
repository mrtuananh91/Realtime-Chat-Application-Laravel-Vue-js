require('./bootstrap');

window.Vue = require('vue');

import Chat from 'vue-beautiful-chat'
Vue.use(Chat);

Vue.component('chat-component', require('./components/ChatComponent.vue'));

const app = new Vue({
    el: '#app'
});
