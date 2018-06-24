/*
 * Copyright (c) 2018. Jake Toolson
 */

import * as decode from 'jwt-decode';
export const JWT_STORAGE_KEY = 'oneupreviews_token';

export function requireAuthMiddleware(to : any, from : any, next : any): void {
    if (!isLoggedIn()) {
        next({
            path: '/',
            query: { redirect: to.fullPath }
        });
    } else {
        next();
    }
}

export function setJwtToken(jwtToken : string): void {
    localStorage.setItem(JWT_STORAGE_KEY, jwtToken);
}

export function clearJwtToken(): void {
    localStorage.removeItem(JWT_STORAGE_KEY);
}

export function getJwtToken(): string|null {
    return localStorage.getItem(JWT_STORAGE_KEY);
}

export function isLoggedIn(): boolean {
    const idToken = getJwtToken();

    return idToken ? !isTokenExpired(idToken) : false;
}

function getTokenExpirationDate(jwtToken : string): Date|null {
    const token = decodeJwtToken(jwtToken);
    if (!token || !token.exp) { return null; }

    const date = new Date(0);
    date.setUTCSeconds(token.exp);

    return date;
}

function isTokenExpired(jwtToken : string): boolean {
    const expirationDate = getTokenExpirationDate(jwtToken);

    return expirationDate ? expirationDate < new Date() : true;
}

function decodeJwtToken(jwtToken : string): any|null {
    return decode(jwtToken);
}
