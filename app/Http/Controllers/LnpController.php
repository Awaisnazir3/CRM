<?php

namespace App\Http\Controllers;

use App\Models\LnpRequest;
use Illuminate\Http\Request;

class LnpController extends Controller
{
    public function index(Request $request)
    {
        $query = LnpRequest::with('customer');

        if ($search = $request->input('search')) {
            $query->where('DIDNumber', 'LIKE', "%{$search}%")
                  ->orWhere('TrackNo', 'LIKE', "%{$search}%")
                  ->orWhere('OID', 'LIKE', "%{$search}%");
        }

        if ($request->has('status') && $request->input('status') !== '' && $request->input('status') !== 'all') {
            $query->where('Status', $request->input('status'));
        }

        $requests = $query->orderBy('ID', 'desc')->paginate(20)->withQueryString();

        return view('lnp.index', compact('requests'));
    }

    public function update(Request $request, $id)
    {
        $lnp = LnpRequest::findOrFail($id);
        $lnp->update([
            'Status' => $request->input('Status', $lnp->Status),
            'TrackNo' => $request->input('TrackNo', $lnp->TrackNo),
            'CompletionDate' => $request->input('CompletionDate', $lnp->CompletionDate),
        ]);

        return back()->with('success', "LNP porting request #{$lnp->ID} updated successfully.");
    }
}
