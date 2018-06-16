/*
 * Copyright (c) 2018. Jake Toolson
 */

import Vue from 'vue';
import App from './containers/App.vue';
import {router} from './router';
import {store} from "./store";

new Vue({
    el: '#root',
    template: '<App/>',
    router,
    store,
    components: {
        App,
    }
});