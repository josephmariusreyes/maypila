<?php
namespace App\Http\Controllers;

use App\Http\Requests\Customer\{
    StoreCustomerRequest
};
use Illuminate\Http\Request;

/**
 * Manages customers that will be added to or updated in the queue.
 * Handles listing, showing, creating, updating, and deleting customer records
 * relevant to the queue system.
 */

class CustomerController extends Controller
{
    // Display a listing of events
    public function index()
    {
        // ...fetch and return all events

        // filter by company
    }

    // Show a single event
    public function show($id)
    {
        // ...fetch and return a single event by $id
    }

    // Store a new event
    public function store(StoreCustomerRequest $request)
    {
        // ...validate and create a new event
    }

    // Update an existing event
    public function update(StoreCustomerRequest $request, $id)
    {
        // ...validate and update the event by $id
    }

    // Delete an event
    public function destroy($id)
    {
        // ...delete the event by $id
    }
}
