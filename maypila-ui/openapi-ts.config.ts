import { defineConfig } from '@hey-api/openapi-ts';

export default defineConfig({
    //input: './openapi.yaml',
    input: 'http://127.0.0.1:8000/docs.openapi',
    output: './src/app/api/generated'
});