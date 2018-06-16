/*
 * Copyright (c) 2018. Jake Toolson
 */

import Vue from 'vue';
import routes from './routes';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

let router = new VueRouter({
    mode: 'history',
    routes: routes,
    scrollBehavior (to, from, savedPosition) {
        return { x: 0, y: 0 }
    },
});

const getRouteObjectByName = (name: string) => {
    return router.resolve({
        name: name
    });
};

const getRouteByName = (name: string, params: any) => {
    let route = router.resolve({
        name: name,
        params: params
    });

    return route ? route.href : null;
};

export {router, getRouteObjectByName, getRouteByName};


