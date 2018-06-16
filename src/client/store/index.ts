/*
 * Copyright (c) 2018. Jake Toolson
 */

import Vue from 'vue';
import Vuex from 'vuex';
import {SET_JWT} from "./mutation.types";

Vue.use(Vuex);

const initialState = {
    jwt : null,
};

const state = (<any> Object).assign({}, initialState);

const store = new Vuex.Store({
    modules: {},
    state: initialState,
    mutations: {
        [SET_JWT] (state, jwt) {
            state.jwt = jwt;
        },
    },
    actions: {},
    getters: {
        jwt: state => state.jwt
    },
});

export {initialState, state, store};
