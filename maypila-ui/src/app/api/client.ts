import { client } from './generated/client.gen';
import { API_BASE_URL } from '@/config';

client.setConfig({
    baseUrl: API_BASE_URL,
    headers: {
        Accept: 'application/json',
    },
});

export { client };
