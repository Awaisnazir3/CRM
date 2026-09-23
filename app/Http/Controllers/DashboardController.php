<?php

namespace App\Http\Controllers;

use App\Models\Cdr;
use App\Models\Complain;
use App\Models\Customer;
use App\Models\Did;
use App\Models\LnpRequest;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // High-level statistics
        $totalDids = Did::count();
        $activeDids = Did::where('Status', 1)->count();
        $availableDids = Did::where('Status', 0)->count();
        $reservedDids = Did::where('Status', 2)->count();
        
        $totalCustomers = Customer::count();
        $totalVendors = Vendor::count();
        $openTickets = Complain::where('IsResolved', 0)->count();
        $pendingLnp = LnpRequest::where('Status', 0)->count();

        // Recent Activity / Records
        $recentDids = Did::orderBy('Id', 'desc')->limit(6)->get();
        $recentCustomers = Customer::orderBy('UID', 'desc')->limit(5)->get();
        $recentTickets = Complain::where('IsResolved', 0)->orderBy('DateTime', 'desc')->limit(5)->get();
        $recentCdrs = Cdr::orderBy('id', 'desc')->limit(6)->get();
        $recentOrders = Order::orderBy('OID', 'desc')->limit(5)->get();

        // Financial snapshot
        $recentPayments = DB::table('OnlinePayments')->orderBy('ID', 'desc')->limit(5)->get();
        
        // CDR Stats (Last 24h/Sample)
        $answeredCalls = Cdr::where('disposition', 'ANSWERED')->count();
        $failedCalls = Cdr::whereIn('disposition', ['FAILED', 'NO ANSWER', 'BUSY'])->count();

        return view('dashboard.index', compact(
            'totalDids',
            'activeDids',
            'availableDids',
            'reservedDids',
            'totalCustomers',
            'totalVendors',
            'openTickets',
            'pendingLnp',
            'recentDids',
            'recentCustomers',
            'recentTickets',
            'recentCdrs',
            'recentOrders',
            'recentPayments',
            'answeredCalls',
            'failedCalls'
        ));
    }
}
