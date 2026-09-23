<?php

namespace App\Http\Controllers;

use App\Models\Cdr;
use Illuminate\Http\Request;

class CdrController extends Controller
{
    public function index(Request $request)
    {
        $query = Cdr::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('callerid', 'LIKE', "%{$search}%")
                  ->orWhere('callednum', 'LIKE', "%{$search}%")
                  ->orWhere('calleridname', 'LIKE', "%{$search}%")
                  ->orWhere('ringto', 'LIKE', "%{$search}%");
            });
        }

        if ($disposition = $request->input('disposition')) {
            $query->where('disposition', $disposition);
        }

        if ($trunk = $request->input('trunk')) {
            $query->where('trunk', 'LIKE', "%{$trunk}%");
        }

        if ($oid = $request->input('oid')) {
            $query->where('OID', $oid);
        }

        // Fast simplePaginate for 2.4M rows
        $cdrs = $query->orderBy('id', 'desc')->simplePaginate(25)->withQueryString();

        return view('cdrs.index', compact('cdrs'));
    }

    public function show($id)
    {
        $cdr = Cdr::with('customer')->findOrFail($id);
        return view('cdrs.show', compact('cdr'));
    }
}
