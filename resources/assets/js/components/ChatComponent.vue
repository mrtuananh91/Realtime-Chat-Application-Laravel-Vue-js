<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Chats</div>
                <div class="card-body">
                    <chat-messages-component :conversation-id="conversationId"></chat-messages-component>
                    <chat-form-component></chat-form-component>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Users</div>
                <div class="card-body">
                    <div class="users" v-for="user in users" :key="user.id">
                        <a href="#" v-on:click="conversationId = user.id">{{ user.name }}</a>
                    </div>
                </div>
            </div>
        </div>
        conversationId = {{conversationId}}

        {{users}}

    </div>

</template>

<script>

    import Event from '../event.js';

    export default {

        data() {
            return {
                users: [],
                conversationId: 0,
            }
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

<style>
    .users {
        background-color: #fff;
        border-radius: 3px;
    }
</style>
