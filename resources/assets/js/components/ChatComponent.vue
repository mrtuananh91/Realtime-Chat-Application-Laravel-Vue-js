<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <beautiful-chat
                :agentProfile="agentProfile"
                :onMessageWasSent="sendMessage"
                :messageList="messageList"
                :newMessagesCount="newMessagesCount"
                :isOpen="isChatOpen"
                :close="closeChat"
                :open="openChat"
                :showEmoji="true"
                :showFile="false"
                :showTypingIndicator="showTypingIndicator"
                :colors="colors"
                :alwaysScrollToBottom="alwaysScrollToBottom"
            />
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Users</div>
                <div class="card-body">
                    <div class="users" v-for="user in users" :key="user.id">
                        <a href="#" v-on:click="getConversationId(user.id)">{{ user.name }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Event from '../event.js';
    import availableColors from '../colors';

    export default {
        name: "VueBeautifulChatComponent",

        data() {
            return {
                agentProfile: {
                    teamName: 'Vue Beautiful Chat',
                    imageUrl: 'https://a.slack-edge.com/66f9/img/avatars-teams/ava_0001-34.png'
                },
                messageList: [],
                newMessagesCount: 0,
                isChatOpen: false,
                showTypingIndicator: true,
                colors: availableColors['green'],
                chosenColor: null,
                alwaysScrollToBottom: true,

                users: [],
                conversationId: 0,
                messages: [],
            }
        },

        methods: {
            getConversationId(userId){
                axios.get('/conversations/' + userId).then((response) => {
                    this.conversationId = response.data;
                    this.getMessages();
                    this.openChat();
                });
            },

            getMessages() {
                axios.get('/message/' + this.conversationId).then((response) => {
                    this.messageList = response.data;
                });
                Event.$on('added_message', (message) => {
                    let msg = {
                        author: Laravel.user.id == message.user_id ? 'me' : 'them',
                        type: "text",
                        data: {
                            text: message.body,
                        }
                    };
                    this.messageList.push(msg);
                });
            },
            openChat() {
                this.isChatOpen = true;
                this.newMessagesCount = 0;
            },
            closeChat() {
                this.isChatOpen = false
            },
            sendMessage(msg) {
                if(msg.type === 'text' && msg.data.text.trim() === '') {
                    return
                }

                this.messageList.push(msg);

                console.log(msg.data);

                axios.post('/message', {
                    conversation_id: this.conversationId,
                    body: msg.type === 'text' ? msg.data.text.trim() : msg.data.emoji,
                    type: msg.type
                }).catch(() => {
                    console.log('failed');
                });
            },
        },

        mounted() {
            Event.$on('users.here', (users) => {
                this.users = users;
            })
                .$on('users.joined', (user) => {
                    this.users.unshift(user);
                })
                .$on('users.left', (user) => {
                    this.users = this.users.filter(u => {
                        return u.id != user.id
                    });
                });
        }
    }
</script>

<style scoped>

</style>
