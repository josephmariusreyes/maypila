## Goal
Implement working functionality for 
- src\features\company\pages\CreateCompanyPage.vue
- src\features\company\component\CreateCompanyForm.vue

## Instruction

#1. 
- 'CreateCompanyPage.vue' should be the container component 
- 'CreateCompanyForm.vue' to 'CreateCompanyPage.vue' and just pass the needed properties onto 'CreateCompanyForm.vue'

#2. After #1
- in 'src\features\company\services\company.service.ts' ADD a method there called 'createCompany'
- in 'src\features\company\types\company.types.ts' create a type here for the payload for 'createCompany' method call it createCompanyRequest
- 'createCompany' method will call 'postApiCompanies' method ( src\app\api\generated\sdk.gen.ts )
- 'createCompany' will return the response from 'postApiCompanies' 
- call 'createCompany' from 'CreateCompanyPage.vue' on onSubmit 

#3 In CreateCompanyForm.vue
- On successfull submit show a dialog ( Use the shadcn dialog ) for now just output the json response from 'createUserAccount' ( I still need to think what i will put in the dialog )
- On fail submit add a error using the setErrors from useForm composable

## completed
- Added `createCompanyRequest` and `companyService.createCompany`, wired to the generated `postApiCompanies` API method.
- Moved create-company validation and submit handling into `CreateCompanyPage.vue`; it maps form fields to the API payload and opens a response dialog on success.
- Updated `CreateCompanyForm.vue` to receive submit/error/loading/response props, show shadcn dialog JSON output, and surface page-level validation/API errors.
- Verified with `npm run build`.
