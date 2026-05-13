<?php

namespace App\Http\Controllers;

use App\Http\Requests\QueueSession\AddUserQueueSessionRequest;
use App\Http\Requests\QueueSession\IndexQueueSessionRequest;
use App\Http\Requests\QueueSession\RemoveUserQueueSessionRequest;
use App\Http\Requests\QueueSession\ShowQueueSessionRequest;
use App\Http\Requests\QueueSession\StoreQueueSessionRequest;
/**
 * Class EventsController
 *
 * Responsible for handling HTTP requests related to events where customer queuing occurs.
 * Manages creation, retrieval, updating, and deletion of events, which can represent
 * various scenarios such as hospital operations, government relief efforts, or any
 * business process requiring a queue.
 */
class QueueSessionController extends Controller
{
    public function index(IndexQueueSessionRequest $request)
    {
    }

    // Show a single event
    public function show(ShowQueueSessionRequest $request, $id)
    {
        // ...fetch and return a single event by $id
    }

    // Store a new event
    public function store(StoreQueueSessionRequest $request)
    {
        // ...validate and create a new event
    }

    // Update an existing event
    public function update(Request $request, $id)
    {
        // ...validate and update the event by $id
    }

    // Delete an event
    public function destroy($id)
    {
        // ...delete the event by $id
    }

    public function addQueueUser(AddUserQueueSessionRequest $request, $id)
    {

    }

    public function removeQueueUser(RemoveUserQueueSessionRequest $request, $id, $userId)
    {

    }
}
