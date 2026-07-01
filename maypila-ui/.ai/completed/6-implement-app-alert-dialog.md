## Goal
- I want to create a common component that can be used to show the shadcn alert dialog
- I want to avoid having to repeatedly place the <AlertDialog> component in evey place i want to use it
- They way i want this to be used is in the component where i need a alert dialog, I will just call a function for example function is called "showAlertDialog()"
- showAlertDialog will take in 3 parameters, title, description, callback method that will be executed on continue

## Instruction
- Provide to me an implementation of what i need to achieve specified goal above

- use src\components\shared\AppAlertDialog.vue component this is where the shadcn alertDialog is placed and this is the component where we will receive the title, desciption, callback properties 

- In src\features\user-accounts\pages\CreateUserPage.vue line 119, call here the  showAlertDialog() method, pass test string for title and description for now, I want to see it working

## Completed
- Updated `src\components\shared\AppAlertDialog.vue` into a reusable programmatic alert dialog with an exposed `showAlertDialog(title, description, callback)` method.
- The dialog now receives the title and description dynamically, runs the supplied callback when the user clicks Continue, then clears the callback and closes the dialog.
- Added a single `<AppAlertDialog ref="appAlertDialog" />` instance to `src\features\user-accounts\pages\CreateUserPage.vue`.
- Called `showAlertDialog()` after a successful create-user response with test title and description strings. The Continue callback stores the response, formats it, and opens the response dialog.
- Verified the implementation with `npm run build`.
- Adjusted `showAlertDialog()` to accept an options object instead of positional parameters.
- Added optional `cancelText` and `continueText` options so each usage can customize the action button labels.
