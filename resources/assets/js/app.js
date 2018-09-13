require('./bootstrap');

window.Vue = require('vue');

import Chat from 'vue-beautiful-chat'
Vue.use(Chat);

Vue.component('chat-component', require('./components/ChatComponent.vue'));
Vue.component('chat-messages-component', require('./components/ChatMessageComponent.vue'));
Vue.component('chat-form-component', require('./components/ChatFormComponent.vue'));
Vue.component('message-component', require('./components/MessageComponent.vue'));

Vue.component('vue-beautiful-chat-component', require('./components/VueBeautifulChatComponent.vue'));

const app = new Vue({
    el: '#app'
});
