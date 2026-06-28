## Goal
Implement working functionality for 
- src\features\user-accounts\pages\CreateUserPage.vue
- src\features\user-accounts\components\CreateUserForm.vue

## Instruction

#1. 
- 'src\features\user-accounts\pages\CreateUserPage.vue' should be the container component 
- 'src\features\user-accounts\components\CreateUserForm.vue' to 'src\features\user-accounts\pages\CreateUserPage.vue' and just pass the needed properties onto CreateUserForm.vue

#2. After #1
- in 'src\features\user-accounts\services\user-accounts.service.ts' ADD a method there called createUserAccount 
- in 'src/features/user-accounts/types/user-accounts.types.ts' create a type here for the payload for createUserAccount method call it createUserAccountRequest
- createUserAccount method will call 'postApiUsers' method ( src\app\api\generated\sdk.gen.ts )
- createUserAccount will return the response from 'postApiUsers' 
- call createUserAccount from CreateUserPage.vue on onSubmit 

#3 In CreateUserForm.vue
- On successfull submit show a dialog ( Use the shadcn dialog ) for now just output the json response from createUserAccount ( I still need to think what i will put in the dialog )
- On fail submit add a error using the setErrors from useForm composable

## completed
- Added `createUserAccountRequest` and implemented `UserAccountsService.createUserAccount`, wired to the generated `postApiUsers` API method.
- Moved create-user validation and submit handling into `CreateUserPage.vue`; it maps first/last name to API `name`, uses the logged-in user's company id, and opens a response dialog on success.
- Updated `CreateUserForm.vue` to receive submit/error/loading/response props, use an API-compatible role selector, show shadcn dialog JSON output, and surface page-level validation/API errors.
- Verified with `npm run build`.
