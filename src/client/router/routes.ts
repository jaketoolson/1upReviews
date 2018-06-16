/*
 * Copyright (c) 2018. Jake Toolson
 */

export default [
    {
        path: '/',
        // component: Home,
        name: 'home',
    },
    {
        path: '/auth',
        children : [
            {
                path: 'login',
                name: 'api.planets'
            },
            {
                path: 'planets/:id',
                name: 'api.planets.show'
            },
            {
                path: 'galaxies',
                name: 'api.galaxies'
            },
            {
                path: 'amenities',
                name: 'api.amenities'
            },
        ],
    },
    {
        path: '*',
        redirect: { name: 'home' }
    }
];