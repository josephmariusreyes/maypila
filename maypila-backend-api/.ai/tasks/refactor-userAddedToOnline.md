## Goal
- Refactor app\Events\User\UserAddedToOnlineQueue.php

## Instruction
- Delete app\Events\User\UserAddedToOnlineQueue.php this event and also the listender

- Now create a queue job named sendEmail
-- The parameters for this job is $user and and array of metadata
-- create a mailable UserAddedToQueueEmail via php artisan make:mail UserAddedToQueueEmail, just add lorem ipsum for subject and body create a simple blade template for this 

- In app\Services\QueueSession\QueueSessionService.php > addQueueUser method
-- instead of dispatching UserAddedToOnlineQueue call the job sendEmail pass the 

## Completed

- Deleted `app\Events\User\UserAddedToOnlineQueue.php` and `app\Listeners\User\HandleUserAddedToOnlineQueue.php`.
- Created the queued job `app\Jobs\sendEmail.php` with `User $user` and `array $metadata` constructor parameters.
- Created `app\Mail\UserAddedToQueueEmail.php` through Artisan and configured it with a lorem ipsum subject and Blade view.
- Added the simple email template at `resources\views\emails\user-added-to-queue.blade.php`.
- Updated `app\Services\QueueSession\QueueSessionService.php` to dispatch `sendEmail` after commit instead of dispatching `UserAddedToOnlineQueue`.
- Removed the deleted user event/listener registration from `app\Providers\AppServiceProvider.php`.
