<?php

namespace App\Http\Controllers;

use App\Models\Cdr;
use Illuminate\Http\Request;

class CdrController extends Controller
{
    public function index(Request $request)
    {
        $query = Cdr::query()->select([
            'id', 'calldate', 'clid', 'src', 'dst', 'dcontext', 'channel',
            'dstchannel', 'lastapp', 'lastdata', 'duration', 'billsec',
            'disposition', 'amaflags', 'accountcode', 'uniqueid', 'userfield',
            'callednum', 'callerid', 'calleridname', 'ringto', 'trunk', 'cost', 'OID'
        ]);

        if ($search = $request->input('search')) {
            $cleanNumber = preg_replace('/[^0-9]/', '', $search);
            if ($cleanNumber) {
                $query->where(function ($q) use ($cleanNumber, $search) {
                    $q->where('callednum', 'LIKE', "{$cleanNumber}%")
                      ->orWhere('callerid', 'LIKE', "{$cleanNumber}%")
                      ->orWhere('OID', $cleanNumber)
                      ->orWhere('calleridname', 'LIKE', "%{$search}%");
                });
            } else {
                $query->where(function ($q) use ($search) {
                    $q->where('calleridname', 'LIKE', "%{$search}%")
                      ->orWhere('trunk', 'LIKE', "{$search}%")
                      ->orWhere('ringto', 'LIKE', "%{$search}%");
                });
            }
        }

        if ($disposition = $request->input('disposition')) {
            $query->where('disposition', $disposition);
        }

        if ($trunk = $request->input('trunk')) {
            $query->where('trunk', 'LIKE', "{$trunk}%");
        }

        if ($oid = $request->input('oid')) {
            $query->where('OID', $oid);
        }

        // Fast simplePaginate for huge tables
        $cdrs = $query->orderBy('id', 'desc')->simplePaginate(25)->withQueryString();

        return view('cdrs.index', compact('cdrs'));
    }

    public function show($id)
    {
        $cdr = Cdr::with('customer')->findOrFail($id);
        return view('cdrs.show', compact('cdr'));
    }
}
