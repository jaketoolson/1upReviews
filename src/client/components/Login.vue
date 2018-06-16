<!--
  - Copyright (c) 2018. Jake Toolson
  -->
<template>
    <div>
        <div class="form-group">
            <input type="text" class="form-control" autocomplete="off" v-model="username" name="username">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" autocomplete="off" v-model="password" name="password">
        </div>
        <div class="form-group">
            <button class="btn btn-block btn-primary" type="button" @click.prent.default="login()">Login</button>
        </div>
    </div>
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
                ApiService.post('/api/auth/login', {username: this.username, password: this.password});
            }
        }
    }
</script>