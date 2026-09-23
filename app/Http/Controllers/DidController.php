<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Customer;
use App\Models\Did;
use App\Models\DidOption;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DidController extends Controller
{
    /**
     * Manage All DIDs (Matching Screenshot 1)
     */
    public function index(Request $request)
    {
        $query = Did::query();

        // 1. Filter by DID Number
        if ($searchDid = $request->input('search_did', $request->input('search'))) {
            $query->where('DIDNumber', 'LIKE', "%{$searchDid}%");
        }

        // 2. Filter by Country
        if ($country = $request->input('country')) {
            $query->where(function ($q) use ($country) {
                $q->where('CountryN', 'LIKE', "%{$country}%")
                  ->orWhere('AreaID', $country)
                  ->orWhere('CountryCd', $country);
            });
        }

        // 3. Filter by Status
        if ($request->has('status') && $request->input('status') !== '' && $request->input('status') !== 'all') {
            $statusVal = $request->input('status');
            if ($statusVal === 'sold') {
                $query->whereIn('Status', [1, 2]);
            } elseif ($statusVal === 'available') {
                $query->where('Status', 0);
            } elseif ($statusVal === 'suspended') {
                $query->where(function ($q) {
                    $q->where('SuspendDID', 1)->orWhere('Status', 3);
                });
            } else {
                $query->where('Status', $statusVal);
            }
        }

        // 4. Filter by Date Range (From Date / To Date)
        if ($fromDate = $request->input('from_date')) {
            $query->where('OfferDate', '>=', $fromDate);
        }
        if ($toDate = $request->input('to_date')) {
            $query->where('OfferDate', '<=', $toDate . ' 23:59:59');
        }

        // 5. Filter by Vendor
        if ($vendor = $request->input('vendor')) {
            if ($vendor !== 'all') {
                $query->where('GroupVendor', $vendor);
            }
        }

        // 6. Filter by Vendor User ID
        if ($vendorUid = $request->input('vendor_uid')) {
            $query->where('GroupVendor', $vendorUid);
        }

        // 7. Filter by Buyer OID
        if ($oid = $request->input('oid')) {
            $query->where('OID', $oid);
        }

        // Per page selector
        $perPage = (int) $request->input('per_page', 25);
        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 25;
        }

        $dids = $query->orderBy('Id', 'desc')->paginate($perPage)->withQueryString();

        // 5 Summary Stat Cards matching Screenshot 1
        $totalDids = Did::count();
        $soldCount = Did::whereIn('Status', [1, 2])->orWhere('OID', '>', 0)->count();
        $suspendedCount = Did::where('SuspendDID', 1)->orWhere('Status', 3)->count();
        $availableCount = Did::where('Status', 0)->where('SuspendDID', 0)->count();
        $agingCount = Did::where('Status', 0)->where('OfferDate', '<', now()->subDays(90))->count();

        $stats = [
            'total' => $totalDids,
            'sold' => $soldCount,
            'suspended' => $suspendedCount,
            'available' => $availableCount,
            'aging' => $agingCount,
        ];

        $countries = Country::orderBy('CountryName', 'asc')->get();
        $vendors = Vendor::orderBy('vendorname', 'asc')->get();

        return view('dids.index', compact('dids', 'stats', 'countries', 'vendors', 'perPage'));
    }

    /**
     * DID Allocation View (Matching Screenshot 2)
     */
    public function allocate(Request $request)
    {
        $didNumber = $request->input('did', '');
        $selectedDid = null;

        if ($didNumber) {
            $selectedDid = Did::where('DIDNumber', $didNumber)->orWhere('Id', $didNumber)->first();
        }

        $recentAvailable = Did::where('Status', 0)->limit(10)->get();

        return view('dids.allocate', compact('didNumber', 'selectedDid', 'recentAvailable'));
    }

    /**
     * Store DID Allocation
     */
    public function storeAllocation(Request $request)
    {
        $request->validate([
            'DIDNumber' => 'required',
            'OID' => 'required',
        ]);

        $did = Did::where('DIDNumber', $request->input('DIDNumber'))
                  ->orWhere('Id', $request->input('DIDNumber'))
                  ->firstOrFail();

        $buyerOid = $request->input('OID');
        $ringTo = $request->input('RingTo', 'echo@us1.didx.net');
        $vendorUid = $request->input('VendorUID', $did->GroupVendor);

        // Update DID status to Allocated/Sold (Status = 2)
        $did->update([
            'OID' => $buyerOid,
            'Status' => 2,
            'iURL' => $ringTo,
            'iPurchasedDate' => now(),
            'GroupVendor' => $vendorUid ?: $did->GroupVendor,
        ]);

        // Record in BuyHistory
        DB::table('BuyHistory')->insert([
            'DIDNumber' => $did->DIDNumber,
            'OID' => $buyerOid,
            'Date' => now(),
            'Place' => 'CRM-ADMIN',
            'Activity' => 'Manual CRM Allocation',
            'Person' => session('crm_user.name', 'Admin User'),
            'OfferedDate' => now()->toDateString(),
        ]);

        // Record in AlterRingTo
        DB::table('AlterRingTo')->insert([
            'OID' => $buyerOid,
            'DID' => $did->DIDNumber,
            'RingTo' => $ringTo,
            'Flag' => 1,
            'Status' => 1,
            'Date' => now(),
        ]);

        return redirect()->route('dids.show', $did->Id)->with('success', "DID +{$did->DIDNumber} successfully allocated to Buyer OID #{$buyerOid}.");
    }

    /**
     * Bulk Allocation View
     */
    public function bulkAllocation()
    {
        $vendors = Vendor::orderBy('vendorname', 'asc')->get();
        $countries = Country::orderBy('CountryName', 'asc')->get();
        return view('dids.bulk-allocation', compact('vendors', 'countries'));
    }

    /**
     * Process Bulk Allocation
     */
    public function storeBulkAllocation(Request $request)
    {
        $request->validate([
            'dids_list' => 'required|string',
            'OID' => 'required',
        ]);

        $dids = array_filter(array_map('trim', explode("\n", $request->input('dids_list'))));
        $buyerOid = $request->input('OID');
        $ringTo = $request->input('RingTo', 'echo@us1.didx.net');
        $count = 0;

        foreach ($dids as $number) {
            $cleanNumber = preg_replace('/[^0-9]/', '', $number);
            if (!$cleanNumber) continue;

            $did = Did::where('DIDNumber', $cleanNumber)->first();
            if ($did) {
                $did->update([
                    'OID' => $buyerOid,
                    'Status' => 2,
                    'iURL' => $ringTo,
                    'iPurchasedDate' => now(),
                ]);

                DB::table('BuyHistory')->insert([
                    'DIDNumber' => $did->DIDNumber,
                    'OID' => $buyerOid,
                    'Date' => now(),
                    'Place' => 'CRM-ADMIN-BULK',
                    'Activity' => 'Bulk Allocation',
                    'Person' => session('crm_user.name', 'Admin User'),
                ]);

                $count++;
            }
        }

        return redirect()->route('dids.index')->with('success', "Successfully bulk allocated {$count} DIDs to Customer OID #{$buyerOid}.");
    }

    /**
     * Allocation History View
     */
    public function allocationHistory(Request $request)
    {
        $search = $request->input('search');
        $query = DB::table('BuyHistory')->orderBy('Date', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('DIDNumber', 'LIKE', "%{$search}%")
                  ->orWhere('OID', 'LIKE', "%{$search}%")
                  ->orWhere('Activity', 'LIKE', "%{$search}%")
                  ->orWhere('Person', 'LIKE', "%{$search}%");
            });
        }

        $history = $query->paginate(25)->withQueryString();

        return view('dids.allocation-history', compact('history', 'search'));
    }

    /**
     * Requested DIDs / Backorder Queue
     */
    public function requestedDids(Request $request)
    {
        $backorders = DB::table('BackOrder')->orderBy('Date', 'desc')->paginate(25)->withQueryString();
        return view('dids.requested', compact('backorders'));
    }

    /**
     * Approval Queue (KYC / Document Verification)
     */
    public function approvalQueue(Request $request)
    {
        $pendingDids = Did::where('NeedDocs', 1)->orWhere('UnderCheck', 1)->orderBy('Id', 'desc')->paginate(25)->withQueryString();
        return view('dids.approval-queue', compact('pendingDids'));
    }

    /**
     * Ready To Commit Queue
     */
    public function readyToCommit(Request $request)
    {
        $commitDids = Did::where('Status', 0)->whereNotNull('OfferDate')->orderBy('OfferDate', 'desc')->paginate(25)->withQueryString();
        return view('dids.ready-to-commit', compact('commitDids'));
    }

    /**
     * Monthly Reconciliation View
     */
    public function monthlyReconciliation(Request $request)
    {
        $month = $request->input('month', date('n'));
        $year = $request->input('year', date('Y'));

        $reconciliation = DB::table('DIDS')
            ->select(
                'GroupVendor',
                DB::raw('COUNT(*) as total_dids'),
                DB::raw('SUM(MonthlyCharges) as customer_mrc'),
                DB::raw('SUM(OurMonthlyCharges) as vendor_mrc'),
                DB::raw('SUM(MonthlyCharges - OurMonthlyCharges) as gross_margin')
            )
            ->where('Status', 2)
            ->groupBy('GroupVendor')
            ->orderBy('total_dids', 'desc')
            ->paginate(25);

        return view('dids.monthly-reconciliation', compact('reconciliation', 'month', 'year'));
    }

    /**
     * Comprehensive DID Details View (Matching Screenshot 3)
     */
    public function show($id)
    {
        $did = Did::with(['customer', 'option'])->where('Id', $id)->orWhere('DIDNumber', $id)->firstOrFail();
        $history = DB::table('BuyHistory')->where('DIDNumber', $did->DIDNumber)->orderBy('Date', 'desc')->limit(20)->get();
        $recentCalls = DB::table('cdrs_new')->where('callednum', 'LIKE', "%{$did->DIDNumber}%")->orWhere('callerid', 'LIKE', "%{$did->DIDNumber}%")->orderBy('id', 'desc')->limit(10)->get();
        $option = DidOption::where('didid', $did->DIDNumber)->first();
        $vendor = Vendor::where('vendorid', $did->GroupVendor)->first();

        return view('dids.show', compact('did', 'history', 'recentCalls', 'option', 'vendor'));
    }

    /**
     * Change Route (Ring-To URL)
     */
    public function changeRoute(Request $request, $id)
    {
        $did = Did::findOrFail($id);
        $newRoute = $request->input('RingTo');

        $did->update(['iURL' => $newRoute]);

        DB::table('AlterRingTo')->insert([
            'OID' => $did->OID ?: 0,
            'DID' => $did->DIDNumber,
            'RingTo' => $newRoute,
            'Flag' => 1,
            'Status' => 1,
            'Date' => now(),
        ]);

        return back()->with('success', "Routing for +{$did->DIDNumber} updated to {$newRoute}.");
    }

    /**
     * Release DID back to available inventory
     */
    public function releaseDid(Request $request, $id)
    {
        $did = Did::findOrFail($id);
        $prevOid = $did->OID;

        $did->update([
            'OID' => 0,
            'Status' => 0,
            'iURL' => '',
            'SuspendDID' => 0,
        ]);

        DB::table('BuyHistory')->insert([
            'DIDNumber' => $did->DIDNumber,
            'OID' => $prevOid ?: 0,
            'Date' => now(),
            'Place' => 'CRM-ADMIN',
            'Activity' => 'Released to Available Pool',
            'Person' => session('crm_user.name', 'Admin User'),
            'ReasonRemove' => $request->input('reason', 'Administrative release via CRM'),
        ]);

        return back()->with('success', "DID +{$did->DIDNumber} has been released and returned to available inventory.");
    }

    /**
     * Toggle Suspend DID
     */
    public function toggleSuspend($id)
    {
        $did = Did::findOrFail($id);
        $newSuspend = $did->SuspendDID ? 0 : 1;
        $did->update(['SuspendDID' => $newSuspend]);

        $msg = $newSuspend ? "DID +{$did->DIDNumber} has been suspended." : "DID +{$did->DIDNumber} has been unsuspended.";
        return back()->with('success', $msg);
    }

    /**
     * Quick JSON API to search Buyers
     */
    public function searchBuyers(Request $request)
    {
        $q = $request->input('q');
        $buyers = Customer::query()
            ->when($q, function ($query, $q) {
                $query->where('CustomerID', 'LIKE', "%{$q}%")
                      ->orWhere('CFName', 'LIKE', "%{$q}%")
                      ->orWhere('CLName', 'LIKE', "%{$q}%")
                      ->orWhere('CCompany', 'LIKE', "%{$q}%")
                      ->orWhere('CEmail', 'LIKE', "%{$q}%");
            })
            ->limit(20)
            ->get(['CustomerID', 'CFName', 'CLName', 'CCompany', 'CEmail']);

        return response()->json($buyers);
    }

    /**
     * Quick JSON API to search DIDs
     */
    public function searchDids(Request $request)
    {
        $q = $request->input('q');
        $dids = Did::query()
            ->when($q, function ($query, $q) {
                $query->where('DIDNumber', 'LIKE', "%{$q}%")
                      ->orWhere('Id', 'LIKE', "%{$q}%")
                      ->orWhere('CountryN', 'LIKE', "%{$q}%")
                      ->orWhere('City', 'LIKE', "%{$q}%");
            })
            ->limit(20)
            ->get(['Id', 'DIDNumber', 'Status', 'CountryN', 'City', 'MonthlyCharges', 'GroupVendor', 'OID']);

        return response()->json($dids);
    }

    public function create()
    {
        $countries = Country::orderBy('CountryName', 'asc')->get();
        $vendors = Vendor::orderBy('vendorname', 'asc')->get();
        $customers = Customer::orderBy('CFName', 'asc')->limit(100)->get();
        return view('dids.create', compact('countries', 'vendors', 'customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'DIDNumber' => 'required|numeric|unique:DIDS,DIDNumber',
            'MonthlyCharges' => 'required|numeric',
        ]);

        $did = Did::create([
            'DIDNumber' => $request->input('DIDNumber'),
            'AreaID' => $request->input('AreaID', 1),
            'Status' => $request->input('Status', 0),
            'SetupCost' => $request->input('SetupCost', 0),
            'MonthlyCharges' => $request->input('MonthlyCharges', 1.00),
            'PerMinuteCharges' => $request->input('PerMinuteCharges', 0),
            'OID' => $request->input('OID', 0),
            'OfferDate' => now(),
            'OurSetupCost' => $request->input('SetupCost', 0),
            'OurMonthlyCharges' => $request->input('MonthlyCharges', 1.00),
            'OurPerMinuteCharges' => $request->input('PerMinuteCharges', 0),
            'GroupVendor' => $request->input('GroupVendor', -1),
            'UnderCheck' => 0,
            'CheckStatus' => 0,
        ]);

        DidOption::create([
            'didid' => $did->DIDNumber,
            'Channels' => $request->input('channels', 2),
            'SellingPrice' => $request->input('MonthlyCharges', 1.00),
            'network' => '0',
            'codec' => '1',
        ]);

        return redirect()->route('dids.show', $did->Id)->with('success', "New DID #{$did->DIDNumber} added to inventory.");
    }

    public function update(Request $request, $id)
    {
        $did = Did::findOrFail($id);
        
        $did->update([
            'MonthlyCharges' => $request->input('MonthlyCharges', $did->MonthlyCharges),
            'SetupCost' => $request->input('SetupCost', $did->SetupCost),
            'PerMinuteCharges' => $request->input('PerMinuteCharges', $did->PerMinuteCharges),
            'Status' => $request->input('Status', $did->Status),
            'City' => $request->input('City', $did->City),
            'StateName' => $request->input('StateName', $did->StateName),
            'iChannel' => $request->input('channels', $did->iChannel),
        ]);

        return back()->with('success', "DID #{$did->DIDNumber} configuration updated successfully.");
    }
}
