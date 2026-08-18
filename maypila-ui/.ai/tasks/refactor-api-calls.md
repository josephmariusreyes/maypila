## Goal
I want to refactor how I am calling my backend API, currently i am calling generated files from heyapi, but i want to get rid of this 

## Instruction
1. delete the api folder under src/app folder

2. under src/app/services/add-to-queue-backend-api "src\app\services\add-to-queue-backend-api\add-to-queue-backend.client.ts" create a re useable client here 

3. src\app\services\add-to-queue-backend-api\add-to-queue-backend.interceptors.ts here in the interceptor add here the bearer token, intecept also the response 

3. use axios to invoke API calls

4. src\features\user-accounts\services\user-accounts.service.ts here replace postApiLogin by using the add-to-queue-backend.client.ts

## completed

- Removed `src/app/api` folder and all runtime imports/usages that depended on generated heyapi SDK calls.
- Implemented reusable Axios client in `src/app/services/add-to-queue-backend-api/add-to-queue-backend.client.ts` with:
	- `baseURL` from `API_BASE_URL`
	- shared `Accept: application/json` header
	- reusable `get` and `post` wrappers returning a consistent `{ data, error, status }` shape
- Implemented interceptor setup in `src/app/services/add-to-queue-backend-api/add-to-queue-backend.interceptors.ts` with:
	- request interceptor that adds `Authorization: Bearer <token>` from local storage
	- response interceptor that handles `401` by clearing auth-related local storage keys
- Migrated API calls to Axios reusable client:
	- `src/features/user-accounts/services/user-accounts.service.ts`
		- replaced `postApiLogin` with `addToQueueBackendClient.post('/api/login', ...)`
		- replaced users listing and creation with Axios calls
	- `src/features/company/services/company.service.ts`
	- `src/features/queue-sessions/services/queue-session.service.ts`
- Replaced generated API-derived TypeScript types with local explicit app types in:
	- `src/features/user-accounts/types/user-accounts.types.ts`
	- `src/features/company/types/company.types.ts`
	- `src/features/queue-sessions/types/queue-session.types.ts`
	- `src/features/queue-sessions/composables/useCreateQueueSession.ts`
	- `src/features/user-accounts/stores/user-accounts.store.ts`
- Removed old side-effect API bootstrap import from `src/main.ts`.
- Validation done: `npm run build` passes successfully.