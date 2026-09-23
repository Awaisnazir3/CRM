<?php

namespace App\Http\Controllers;

use App\Models\BillingHistory;
use App\Models\OnlinePayment;
use App\Models\PayPalAuthorize;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillingController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->input('tab', 'transactions');

        if ($tab === 'invoices') {
            $records = BillingHistory::with('customer')->orderBy('Date', 'desc')->paginate(20)->withQueryString();
        } elseif ($tab === 'online') {
            $records = OnlinePayment::with('customer')->orderBy('Date', 'desc')->paginate(20)->withQueryString();
        } elseif ($tab === 'paypal') {
            $records = PayPalAuthorize::with('customer')->orderBy('date', 'desc')->paginate(20)->withQueryString();
        } else {
            // High performance transaction query on 44M row table
            $query = Transaction::query();

            if ($oid = $request->input('oid')) {
                $query->where('OID', $oid);
            }

            if ($search = $request->input('search')) {
                $query->where(function ($q) use ($search) {
                    $q->where('OID', $search)
                      ->orWhere('DIDID', $search)
                      ->orWhere('ReferenceID', $search);
                });
            }

            if ($type = $request->input('type')) {
                $query->where('Type', $type);
            }

            // Simple pagination to avoid expensive full table COUNT(*) on 44M rows
            $records = $query->orderBy('TransactionID', 'desc')->simplePaginate(25)->withQueryString();
        }

        return view('billing.index', compact('records', 'tab'));
    }
}
