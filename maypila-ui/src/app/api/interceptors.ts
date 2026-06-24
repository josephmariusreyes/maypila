// src/app/api/interceptors.ts

import { client } from './client';

client.interceptors.request.use(async (request) => {
    const token = localStorage.getItem('token');

    if (token) {
        request.headers.set('Authorization', `Bearer ${token}`);
    }

    return request;
});

client.interceptors.response.use(async (response) => {
    if (response.status === 401) {
        localStorage.removeItem('token');

        alert("Enhance this later on to redirect back to login page");
    }

    return response;
});

client.interceptors.error.use(async (error) => {
    alert('API Error: ' + error);

    return error;
});