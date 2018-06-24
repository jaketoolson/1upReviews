/*
 * Copyright (c) 2018. Jake Toolson
 */

import axios from 'axios';
import {JWT_STORAGE_KEY} from "../modules/auth/auth";

export default axios.create({
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Authorization': 'Bearer ' + localStorage.getItem(JWT_STORAGE_KEY)
    }
})
