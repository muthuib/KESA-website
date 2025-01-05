<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::all();
        $tickets = Ticket::paginate(10); // 10 tickets per page
        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:1',
        ]);

        Ticket::create($request->all());

        return redirect()->route('tickets.index')->with('success', 'Ticket created successfully.');
    }

    public function edit(Ticket $ticket)
    {
        return view('tickets.edit', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:1',
        ]);

        $ticket->update($request->all());

        return redirect()->route('tickets.index')->with('success', 'Ticket updated successfully.');
    }

    public function destroy(Ticket $ticket)
    {
        // Check if there are related records in the transactions table
        if ($ticket->transactions()->exists()) {
            return redirect()->route('tickets.index')->with('error', 'Cannot delete this ticket because there are people who have purchased the ticket already.');
        }
    
        $ticket->forceDelete();  // Use forceDelete if soft delete isn't used
    
        return redirect()->route('tickets.index')->with('danger', 'Ticket deleted successfully.');
    }
    

    public function buy()
    {
        $tickets = Ticket::all(); // Fetch all tickets for selection
        return view('tickets.buy', compact('tickets'));
    }
}


