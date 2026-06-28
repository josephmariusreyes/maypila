## Goal
Implement working functionality for 
- src\features\queue-sessions\pages\CreateQueueSessionPage.vue
- src\features\queue-sessions\components\CreateQueueSessionForm.vue

## Instruction

#1. 
- 'CreateQueueSessionPage.vue' should be the container component 
- 'CreateQueueSessionForm.vue' to 'CreateQueueSessionPage.vue'' and just pass the needed properties onto CreateQueueSessionForm.vue

#2. After #1
- in 'src\features\queue-sessions\services\queue-session.service.ts' ADD a method there called createQueueSession 
- in 'src\features\queue-sessions\types\queue-session.types.ts' create a type here for the payload for createQueueSession method call it createQueueSessionRequest
- createQueueSession method will call 'postApiQueueSessions' method ( src\app\api\generated\sdk.gen.ts )
- createQueueSession will return the response from 'postApiQueueSessions' 
- call createQueueSession from CreateQueueSessionPage.vue on onSubmit 

#3 In CreateQueueSessionForm.vue
- On successfull submit show a dialog ( Use the shadcn dialog ) for now just output the json response from createQueueSession ( I still need to think what i will put in the dialog )
- On fail submit add a error using the setErrors from useForm composable

## completed
- Added `createQueueSessionRequest` and implemented `queueSessionService.createQueueSession`, wired to the generated `postApiQueueSessions` API method.
- Moved create-queue-session validation and submit handling into `CreateQueueSessionPage.vue`; it uses the logged-in user's company id and opens a response dialog on success.
- Updated `CreateQueueSessionForm.vue` to receive submit/error/loading/response props, show shadcn dialog JSON output, and surface page-level validation/API errors.
- Verified with `npm run build`.
