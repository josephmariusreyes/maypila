## Goal
- Initial implementation for sending an email when a user is added to a queue

## Instruction

- in app\Events\User\UserAddedToOnlineQueue.php add user as a parameter to construct and add a $metadaya array

- In app\Services\QueueSession\QueueSessionService.php fix how i am dispatching UserAddedToOnlineQueue 

- In app\Listeners\User\HandleUserAddedToOnlineQueue.php implement a basic emailing functionality this will send an email to user just put lorem ipsum text for now

## Completed

- Updated `app\Events\User\UserAddedToOnlineQueue.php` so the event now accepts a `User $user` and a `metadata` array.
- Fixed `app\Services\QueueSession\QueueSessionService.php` to import and dispatch `UserAddedToOnlineQueue` with the queued user plus queue session and actor metadata after commit.
- Implemented basic email sending in `app\Listeners\User\HandleUserAddedToOnlineQueue.php` using `Mail::raw()` with placeholder lorem ipsum text.
- Corrected `app\Providers\AppServiceProvider.php` imports so the `UserAddedToOnlineQueue` event is registered with the correct listener namespace.
