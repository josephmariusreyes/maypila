import { client } from './generated/client.gen';

client.setConfig({
    baseUrl: import.meta.env.VITE_API_URL,
    headers: {
        Accept: 'application/json',
    },
});

export { client };