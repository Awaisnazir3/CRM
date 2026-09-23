<?php

namespace App\Http\Controllers;

use App\Models\Complain;
use App\Models\ComplainThread;
use App\Models\Customer;
use App\Models\VCareTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status', 'open');
        $query = Complain::with('customer');

        if ($status === 'open') {
            $query->where('IsResolved', 0);
        } elseif ($status === 'resolved') {
            $query->where('IsResolved', 1);
        }

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('ComplainID', 'LIKE', "%{$search}%")
                  ->orWhere('Complain', 'LIKE', "%{$search}%")
                  ->orWhere('UID', 'LIKE', "%{$search}%")
                  ->orWhere('DID', 'LIKE', "%{$search}%");
            });
        }

        $tickets = $query->orderBy('DateTime', 'desc')->paginate(20)->withQueryString();

        $openCount = Complain::where('IsResolved', 0)->count();
        $resolvedCount = Complain::where('IsResolved', 1)->count();
        $totalCount = Complain::count();

        return view('tickets.index', compact('tickets', 'openCount', 'resolvedCount', 'totalCount', 'status'));
    }

    public function show($id)
    {
        $ticket = Complain::with(['customer', 'threads'])->where('ComplainID', $id)->firstOrFail();
        return view('tickets.show', compact('ticket'));
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'remarks' => 'required|string',
        ]);

        $ticket = Complain::where('ComplainID', $id)->firstOrFail();
        $currentUser = Session::get('crm_user.name', 'Support Agent');

        ComplainThread::create([
            'ComplainID' => $ticket->ComplainID,
            'Remarks' => $request->input('remarks'),
            'WrittenBy' => $currentUser,
            'AssignTo' => $ticket->Assign ?: 'Support',
            'SentToClient' => 1,
            'date' => now(),
            'Status' => $ticket->IsResolved ? 1 : 0,
            'Notify' => 1,
            'IsReplied' => 1,
            'OID' => $ticket->OID ?: 0,
            'NotifyVendor' => 0,
            'VendorOID' => $ticket->VOID ?: 0,
            'ThreadID' => 'T' . time(),
        ]);

        if ($request->has('resolve')) {
            $ticket->update([
                'IsResolved' => 1,
                'ResolveDate' => now(),
                'ResolvedBy' => $currentUser,
            ]);
        }

        return back()->with('success', 'Reply posted successfully.');
    }

    public function toggleStatus($id)
    {
        $ticket = Complain::where('ComplainID', $id)->firstOrFail();
        $newStatus = $ticket->IsResolved ? 0 : 1;
        $currentUser = Session::get('crm_user.name', 'Support Agent');

        $ticket->update([
            'IsResolved' => $newStatus,
            'ResolveDate' => $newStatus ? now() : null,
            'ResolvedBy' => $newStatus ? $currentUser : null,
        ]);

        $statusText = $newStatus ? 'Resolved' : 'Reopened';
        return back()->with('success', "Ticket #{$ticket->ComplainID} marked as {$statusText}.");
    }

    public function create()
    {
        $customers = Customer::orderBy('CFName', 'asc')->limit(50)->get();
        return view('tickets.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Complain' => 'required|string',
            'UID' => 'required',
        ]);

        $complainId = 'C' . time();
        $ticket = Complain::create([
            'ComplainID' => $complainId,
            'UID' => $request->input('UID'),
            'OID' => $request->input('UID'),
            'Type' => $request->input('Type', 'GEN'),
            'Complain' => $request->input('Complain'),
            'DID' => $request->input('DID', ''),
            'IsResolved' => 0,
            'Notify' => 1,
            'DateTime' => now(),
            'Assign' => 'Support',
        ]);

        return redirect()->route('tickets.show', $ticket->ComplainID)->with('success', "Support ticket #{$ticket->ComplainID} created successfully.");
    }
}
