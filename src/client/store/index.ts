/*
 * Copyright (c) 2018. Jake Toolson
 */

import Vue from 'vue';
import Vuex from 'vuex';
import {authModule} from "../modules/auth/store";

Vue.use(Vuex);

export const store = new Vuex.Store({
    modules: {
        auth: authModule
    },
    state: {},
    mutations: {},
    actions: {},
    getters: {},
});
