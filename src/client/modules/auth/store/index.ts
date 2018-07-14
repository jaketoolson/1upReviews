/*
 * Copyright (c) 2018. Jake Toolson
 */

import {ApiService} from "../../../services/api";
import {setJwtToken, clearJwtToken, getJwtToken} from "../auth";

// Mutations
export const AUTH_SET_JWT = 'setJwt';

// Actions
export const AUTH_LOGIN = 'login';
export const AUTH_LOGOUT = 'logout';
export const AUTH_REFRESH = 'refresh';

const initialState = {
    jwt: null,
};

const state = (<any> Object).assign({}, initialState);

export const authModule = {
    namespaced: true,
    state: state,
    mutations: {
        [AUTH_SET_JWT] (state : any, jwt : string) {
            state.jwt = jwt;
        },
    },
    actions: {
        [AUTH_LOGIN] ({commit} : {commit: any}, credentials : {email: string, password: string}) {
            ApiService.post('/api/auth/login', credentials).then((r : any)=>{
                commit(AUTH_SET_JWT, r.data.access_token);
                setJwtToken(r.data.access_token);
            });
        },
        [AUTH_LOGOUT] ({commit} : {commit: any}) {
            commit(AUTH_SET_JWT, null);
            clearJwtToken();
        },
        [AUTH_REFRESH] () {}
    },
    getters: {
        jwt: (state: any): string|null => state.jwt,
        isLoggedIn: (state: any): boolean => state.jwt
    }
};
