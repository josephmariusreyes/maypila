## Goal
Implement the AppHeaderMenu.vue

## Instruction
- In src\components\AppHeaderMenu.vue, iterate over the appMenu variable and display it to the DialogContent, get rid of the static listing HTML there

- the appMenu array this has a requiredRoles property, check the array of roles there and compare against the logged in user roles, display the link if logged in user has the required roles, you may retrieve role from the authStore

- the redirect link can be found in the redirectTo property in appMenu

- the label should be displayed

- Implement highlighting of current active link, you may retrieve the URL path and compare this againts the name property per link in the appMenu

## completed
- Replaced the static menu links in `src/components/AppHeaderMenu.vue` with a `v-for` over the `appMenu` array.
- Added role-based filtering through the auth store so users only see menu links matching their roles.
- Wired each menu item to its `redirectTo` path and displayed the configured `label`.
- Added active-link highlighting by comparing the current route name against each menu item's `name`.

