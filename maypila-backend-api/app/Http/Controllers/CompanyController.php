<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompanyController extends Controller
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
    public function store(Request $request)
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
}
