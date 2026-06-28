## Goal
Implement working functionality for 
- src\features\queue-sessions\pages\AddCustomerToQueuePage.vue
- src\features\queue-sessions\components\AddCustomerToQueueForm.vue

## Instruction

#1. 
- src\features\queue-sessions\pages\AddCustomerToQueuePage.vue should be the container component 
- move the code logic from src\features\queue-sessions\components\AddCustomerToQueueForm.vue to src\features\queue-sessions\pages\AddCustomerToQueuePage.vue and just pass the needed properties onto AddCustomerToQueueForm

#2. After #1
- in src\features\queue-sessions\services\queue-session.service.ts ADD a method there called addCustomerToQueue 
- in src\features\queue-sessions\types\queue-session.types.ts create a type here for the payload for addCustomerToQueue method call it addCustomerToQueueRequest
- addCustomerToQueue method will call postApiQueueSessionsAddQueueUsers method ( src\app\api\generated\sdk.gen.ts )
- addCustomerToQueue will return the response from postApiQueueSessionsAddQueueUsers 
- call addCustomerToQueue from AddCustomerToQueueForm.vue on onSubmit 

#3 In AddCustomerToQueueForm.vue
- On successfull submit show a dialog ( Use the shadcn dialog ) for now just output the json response from addCustomerToQueue ( I still need to think what i will put in the dialog )
- On fail submit add a error using the setErrors from useForm composable

## completed
- Moved the add-customer form schema, vee-validate form state, and submit handling into `src/features/queue-sessions/pages/AddCustomerToQueuePage.vue`.
- Updated `src/features/queue-sessions/components/AddCustomerToQueueForm.vue` to receive the submit handler, errors, submitting state, and response dialog state as props/model values.
- Added `addCustomerToQueueRequest` and form value types in `src/features/queue-sessions/types/queue-session.types.ts`.
- Added `queueSessionService.addCustomerToQueue`, which calls `postApiQueueSessionsAddQueueUsers` and returns the generated SDK response.
- On successful submit, the form now opens a shadcn dialog showing the JSON response; on failure, the page maps the error into vee-validate `setErrors`.
- Verified the implementation with `npm run build`.
