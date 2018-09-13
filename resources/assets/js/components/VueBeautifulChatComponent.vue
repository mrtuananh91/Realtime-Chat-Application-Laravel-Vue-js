<template>
    <div class="container">
        <!--{{messages}}-->
        <beautiful-chat
            :agentProfile="agentProfile"
            :onMessageWasSent="onMessageWasSent"
            :messageList="messageList"
            :newMessagesCount="newMessagesCount"
            :isOpen="isChatOpen"
            :close="closeChat"
            :open="openChat"
            :showEmoji="true"
            :showFile="true"
            :showTypingIndicator="true"
        />
        <a href="#" @click.prevent="openChat()">Open the chat window</a>
    </div>
</template>

<script>
    import Event from '../event.js';

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

                messages: [],

                messages2: {
                    author: 'aaaa',
                    type: 'text',
                    data: {
                        text: 'some text'
                    }
                },
            }
        },

        created(){
            this.messageList.push(this.messages2);
        },

        methods: {
            sendMessage (msg) {
                this.messages.map(function (message) {
                    this.messageList.push(message);
                    console.log("MESSAGE = ");
                    console.log(message.body);
                });

                console.log("MESSAGE2 = ");

                if (text.length > 0) {
                    this.newMessagesCount = this.isChatOpen ? this.newMessagesCount : this.newMessagesCount + 1;
                    this.messageList.push(msg);
                }
            },
            onMessageWasSent (msg) {
                // this.messages.map(function (message) {
                //     this.messageList2.push(message);
                //     console.log("MESSAGE = ");
                //     console.log(msg);
                //     console.log(message.body);
                // });

                this.messageList.push(this.messages2);
                this.messageList.push(msg);

                console.log(this.messageList);
            },
            openChat () {
                this.isChatOpen = true;
                this.newMessagesCount = 0;
            },
            closeChat () {
                this.isChatOpen = false
            }
        },

        mounted() {
            axios.get('/message').then((response) => {
                this.messages = response.data;
            });
            Event.$on('added_message', (message) => {
                this.messages.unshift(message);
                if(message.selfMessage) {
                    this.$refs.message.scrollTop = 0;
                }
            });
        }
    }
</script>

<style scoped>

</style>
