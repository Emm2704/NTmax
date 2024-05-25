<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportTicketController extends Controller
{
    public function index()
    {
        $supportTickets = SupportTicket::all();
        return view('support_tickets.index', compact('supportTickets'));
    }

    public function create()
    {
        return view('support_tickets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'subject' => 'required|string|max:255',
        ]);

        SupportTicket::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
            'subject' => $request->subject,
        ]);

        return redirect()->route('support_tickets.index')->with('success', 'Ticket de soporte creado correctamente');
    }

    public function show(SupportTicket $supportTicket)
    {
        return view('support_tickets.show', compact('supportTicket'));
    }

    public function edit(SupportTicket $supportTicket)
    {
        return view('support_tickets.edit', compact('supportTicket'));
    }

    public function update(Request $request, SupportTicket $supportTicket)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'subject' => 'required|string|max:255',
        ]);

        $supportTicket->update([
            'title' => $request->title,
            'description' => $request->description,
            'subject' => $request->subject,
        ]);

        return redirect()->route('support_tickets.index')->with('success', 'Ticket de soporte actualizado correctamente');
    }

    public function destroy(SupportTicket $supportTicket)
    {
        $supportTicket->delete();
        return redirect()->route('support_tickets.index')->with('success', 'Ticket de soporte eliminado correctamente');
    }
}
