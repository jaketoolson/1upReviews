/*
 * Copyright (c) 2018. Jake Toolson
 */

import http from '../router/axios'
import {getRouteByName} from "../router";

const ApiService = {
    init () {},
    query (resource: string, params: string|null) {
        return http.get(resource, {params: params})
            .catch((error) => {
                throw new Error(`ApiService ${error}`)
            })
    },
    get (resource: string) {
        return http.get(resource)
            .catch((error) => {
                throw new Error(`ApiService ${error}`)
            })
    },
    post (resource: string, data?: object) {
        return http.post(resource, data)
            .catch((error) => {
                throw new Error(`ApiService ${error}`)
            })
    }
};

export {ApiService};
