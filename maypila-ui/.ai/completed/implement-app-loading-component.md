## Goal
Implement - src\components\shared\AppLoading.vue

## Instruction
- this will be a screen that has a loading spinner icon in the center use the shadcn LoaderIcon
- the background of this will be a gray slightly transparent background and then the loader will be at the center
- make this a resuable component wherein in the caller component they just have to pass a boolean property whether to show or hide this component
- show the loading screen before doing an API call and then hide it after the API has returned data
- for now integrate this in src\features\queue-sessions\pages\CreateQueueSessionPage.vue when we call getAllUsersByCompanyId

## Completed
- Updated `src\components\shared\AppLoading.vue` into a reusable overlay component controlled by a required `show` boolean prop.
- Kept the shadcn/lucide `LoaderIcon` centered on a slightly transparent gray full-screen background.
- Integrated `AppLoading` in `src\features\queue-sessions\pages\CreateQueueSessionPage.vue` and toggled it around `getAllUsersByCompanyId` with a `finally` block so it hides after the API call completes or fails.



