<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cdr;
use App\Models\Complain;
use App\Models\CusDoc;
use App\Models\Customer;
use App\Models\Did;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        if ($search = $request->input('search')) {
            $cleanNumber = preg_replace('/[^0-9]/', '', $search);

            // Direct match lookup for instant redirect
            if ($cleanNumber) {
                $exactCustomer = Customer::where('CustomerID', $cleanNumber)->orWhere('UID', $cleanNumber)->first();
                if ($exactCustomer) {
                    return redirect()->route('customers.show', $exactCustomer->UID);
                }
            }
        }

        $query = Customer::with('address');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('CFName', 'LIKE', "{$search}%")
                  ->orWhere('CLName', 'LIKE', "{$search}%")
                  ->orWhere('CEmail', 'LIKE', "%{$search}%")
                  ->orWhere('CCompany', 'LIKE', "%{$search}%")
                  ->orWhere('UID', 'LIKE', "{$search}%")
                  ->orWhere('CustomerID', 'LIKE', "{$search}%");
            });
        }

        $customers = $query->orderBy('UID', 'desc')->paginate(20)->withQueryString();

        return view('customers.index', compact('customers'));
    }

    public function show($id)
    {
        $customer = Customer::with('address')->where('UID', $id)->orWhere('CustomerID', $id)->firstOrFail();
        
        // Assigned DIDs
        $dids = Did::where('OID', $customer->CustomerID)->orWhere('OID', $customer->UID)->orderBy('Id', 'desc')->paginate(10, ['*'], 'dids_page');
        
        // Orders
        $orders = Order::where('CustomerID', $customer->CustomerID)->orWhere('UID', $customer->UID)->orderBy('OID', 'desc')->get();
        
        // KYC Docs
        $docs = CusDoc::where('OID', $customer->CustomerID)->orWhere('OID', $customer->UID)->orderBy('ID', 'desc')->get();
        
        // Tickets
        $tickets = Complain::where('UID', $customer->UID)->orWhere('OID', $customer->CustomerID)->orderBy('DateTime', 'desc')->get();
        
        // Transactions (limited for performance)
        $transactions = Transaction::where('OID', $customer->CustomerID)->orWhere('OID', $customer->UID)->orderBy('Date', 'desc')->limit(20)->get();

        // Recent CDRs
        $cdrs = Cdr::where('OID', $customer->CustomerID)->orWhere('OID', $customer->UID)->orderBy('id', 'desc')->limit(15)->get();

        // Online Payments
        $payments = DB::table('OnlinePayments')->where('OID', $customer->CustomerID)->orWhere('OID', $customer->UID)->orderBy('ID', 'desc')->get();

        return view('customers.show', compact('customer', 'dids', 'orders', 'docs', 'tickets', 'transactions', 'cdrs', 'payments'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'CFName' => 'required|string|max:50',
            'CLName' => 'required|string|max:50',
            'CEmail' => 'required|email|max:100',
        ]);

        $maxUid = DB::table('customer')->max(DB::raw('CAST(UID AS UNSIGNED)')) ?: 10000;
        $newUid = (string)($maxUid + 1);

        $addressId = 'A' . substr(uniqid(), 0, 8);
        Address::create([
            'AddressID' => $addressId,
            'Street1' => $request->input('Street1', ''),
            'City' => $request->input('City', ''),
            'State' => $request->input('State', ''),
            'ZipCode' => $request->input('ZipCode', ''),
            'Country' => $request->input('Country', 'USA'),
        ]);

        $customer = Customer::create([
            'UID' => $newUid,
            'CustomerID' => $newUid,
            'AddressID' => $addressId,
            'CSalutation' => $request->input('CSalutation', 'Mr.'),
            'CFName' => $request->input('CFName'),
            'CLName' => $request->input('CLName'),
            'CEmail' => $request->input('CEmail'),
            'CCompany' => $request->input('CCompany', ''),
            'CTelOff' => $request->input('CTelOff', ''),
            'CCell' => $request->input('CCell', ''),
            'CWebSite' => $request->input('CWebSite', ''),
        ]);

        User::create([
            'UID' => $newUid,
            'Pass' => $request->input('Password', '123456'),
            'password' => $request->input('Password', '123456'),
            'Type' => 'CUS',
            'IsActive' => 1,
            'IsRemoved' => 0,
            'DateTime' => now(),
        ]);

        return redirect()->route('customers.show', $customer->UID)->with('success', "Customer account #{$customer->UID} created successfully.");
    }
}
