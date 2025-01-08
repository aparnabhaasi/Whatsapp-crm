<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    public function viewSuperadminTickets(){

        $tickets = Ticket::all();
        return view('super-admin.tickets', compact('tickets'));
    }

    public function storeTickets(Request $request){
        // validate data
        $validateData = $request->validate([
            'name' => 'required|string',
            'mobile' => 'required|string',
            'email' => 'required|string',
            'app_id' => 'required|string',
            'description' => 'required|string',
            'img' => 'nullable|mimes:jpg,png,jpeg',
        ]);

        $imagePath = $request->file('img')->store('tickets', 'public');

        // create new instance for ticket
        $ticket = new Ticket();

        $ticket-> name = $validateData['name'];
        $ticket-> mobile = $validateData['mobile'];
        $ticket-> email = $validateData['email'];
        $ticket-> app_id = $validateData['app_id'];
        $ticket-> description = $validateData['description'];
        $ticket-> img = $imagePath;
        $ticket-> status = false;

        $ticket->save();

        return redirect()->back()->with('success', 'Ticket submited, Our team will contact you after verify the issue.');
    }

    public function toggleStatus(Request $request, Ticket $ticket)
    {
        $ticket->status = $request->status;
        $ticket->save();

        return response()->json(['success' => true]);
    }

    public function deleteTicket($id){
        $delete = Ticket::find($id);

        $delete->delete();
        return redirect()->back()->with('success', 'Ticket deleted successfully!');
    }

}
