/*
 * Copyright (c) 2018. Jake Toolson
 */

import {JWT_STORAGE_KEY} from "./helpers";
import {ApiService} from "../services/api";

// Mutations
export const AUTH_SET_JWT = 'setJwt';

// Actions
export const AUTH_LOGIN = 'login';
export const AUTH_LOGOUT = 'logout';
export const AUTH_REFRESH = 'refresh';

const initialState = {
    jwt : null,
    isLoggedIn: !!localStorage.getItem(JWT_STORAGE_KEY)
};

const state = (<any> Object).assign({}, initialState);

export const authModule = {
    namespaced: true,
    state: state,
    mutations: {
        [AUTH_SET_JWT] (state : any, jwt ?: string) {
            state.jwt = jwt;
        },
    },
    actions: {
        [AUTH_LOGIN] ({commit} : {commit: any}, credentials : {email: string, password: string}) {
            ApiService.post('/api/auth/login', credentials).then((r)=>{
                commit(AUTH_SET_JWT, r.data.access_token);
                localStorage.setItem(JWT_STORAGE_KEY, r.data.access_token);
            });
        },
        [AUTH_LOGOUT] ({commit} : {commit: any}) {
            commit(AUTH_SET_JWT, null);
            localStorage.removeItem(JWT_STORAGE_KEY);
        }
    },
    getters: {
        jwt: (state: any) => state.jwt,
        isLoggedIn: (state: any) => state.isLoggedIn
    }
};