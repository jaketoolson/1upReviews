<!--
  - Copyright (c) 2018. Jake Toolson
  -->
<template>
    <span>
        <input type="text" class="form-control" v-model="username" name="username">
        <input type="password" class="form-control" v-model="password" name="password">
        <button class="btn btn-block btn-outline-primary" type="button" @click.prent.default="login()">Login</button>
    </span>
</template>

<script>
    import {ApiService} from "../services/api";

    export default {
        name : "Login",
        data () {
            return {
                username: null,
                password: null,
            };
        },
        methods: {
            login () {
                ApiService.post('/api/auth/login', {username: this.username, password: this.password}).then();
            }
        }
    }
</script>