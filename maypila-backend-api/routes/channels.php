<?php

use Illuminate\Support\Facades\Broadcast;

// Later, when broadcasting is enabled, register the authenticated channels here.
// Example for queue-session scoped customer updates:
// Broadcast::channel('queue-session.{queueSessionId}', function ($user, int $queueSessionId) {
//     // Return true only when the authenticated user may listen to this queue session.
//     // Example checks you might add later:
//     // - the user belongs to the same company
//     // - the user is assigned to this queue session
//     // - the user has CompanyAdmin / QueAdmin / QueEncoder permissions
//
//     // return $user->queue_session_id === $queueSessionId;
//     // return $user->company_id === $queueSession->company_id;
//
//     return false;
// });