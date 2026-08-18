## Goal
- Implement functionality to associate user accounts to an online queue

## Instruction

#1 In "src\features\queue-sessions\components\CreateQueueSessionForm.vue" add validation that queueAdminIds and queueEncoderIds hidden input field have a value before allowing submission
( much preferred implementation if we can add the hidden fields as part of the formSchema in "src\features\queue-sessions\pages\CreateQueueSessionPage.vue" )

#2 In "src\features\queue-sessions\components\CreateQueueSessionForm.vue" when showAddQueueAdminDialog() or showAddQueueEncoderDialog() is invoked emit a event to parent component

#3 Now in "src\features\queue-sessions\pages\CreateQueueSessionPage.vue" handle the emitted event, a dailog will now be show, use the "AlertDialog" component from shadcn, 

#3.1 before showing the dialog call to "getApiUsers" "src\app\api\generated\index.ts" companyId query parameter can be extracted from the authStore()

#3.1 The dialog shown will have the following fields 
- a select drop down option where the app users will be listed, values for the select field will come from the api response of getApiUsers() the value is the id of user and the label is the name of user

- a add user button will also be place at the lower right of the dialog
    - On click of this button the ID of the user will be placed in the hidden input queueAdminIds this is if showAddQueueAdminDialog() if the one called, id of user will be appended to queueEncoderIds if the method called is showAddQueueEncoderDialog()

- after appending the ID close the dialog

## Completed

- Added `queueAdminIds` and `queueEncoderIds` to the create queue session form schema with required array validation, plus initial empty array values.
- Updated `CreateQueueSessionForm.vue` so the queue admin/encoder hidden inputs are backed by VeeValidate fields and the add buttons emit separate parent events.
- Updated `CreateQueueSessionPage.vue` to handle those emitted events, fetch app users with `getApiUsers` using the auth store company ID, show a shadcn `AlertDialog` with a user select, append the selected user ID to the correct hidden field, and close the dialog after adding.
- Extended `CreateQueueSessionFormValues` with the queue admin and encoder ID arrays.
- Removed stale unused symbols from `CreateUserPage.vue` so the project build can complete.
- Verified the implementation with `npm run build`.

