/*
 * Copyright (c) 2018. Jake Toolson
 */

import Login from "../modules/auth/components/Login.vue";
import Home from '../components/Home.vue';
import {requireAuthMiddleware} from "../modules/auth/auth";

export default [
    {
        path: '/',
        name: 'home',
        beforeEnter: requireAuthMiddleware,
        component: Home
    },
    {
        path: '/auth',
        components: {
            default: { template: `<router-view/>`}
        },
        children : [
            {
                path: 'login',
                name: 'auth.login',
                component: Login
            },
        ],
    },
    {
        path: '*',
        redirect: { name: 'home' }
    }
];