<!--
  - Copyright (c) 2018. Jake Toolson
  -->
<template>
    <form>
        <div class="form-group">
            <input title="email" type="text" class="form-control" autocomplete="off" v-model="email" name="email">
        </div>
        <div class="form-group">
            <input  title="password" type="password" class="form-control" autocomplete="off" v-model="password" name="password">
        </div>
        <div class="form-group">
            <button class="btn btn-block btn-primary" type="button" @click.prent.default="login()">Login</button>
        </div>
    </form>
</template>
<script>
    import {AUTH_LOGIN} from "../store";

    export default {
        name : "Login",
        data () {
            return {
                email: null,
                password: null,
            };
        },
        methods: {
            login () {
                this.$store.dispatch('auth/' + AUTH_LOGIN, {
                    email: this.email,
                    password: this.password
                })
            }
        }
    }
</script>
