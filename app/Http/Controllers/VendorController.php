<?php

namespace App\Http\Controllers;

use App\Models\Did;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::all();

        // Single aggregated query cached for performance on 1.8M row DIDS table
        $counts = Cache::remember('vendor_did_counts', 3600, function () {
            try {
                return DB::table('DIDS')
                    ->where('GroupVendor', '>', 0)
                    ->groupBy('GroupVendor')
                    ->select('GroupVendor', DB::raw('count(*) as total'))
                    ->pluck('total', 'GroupVendor')
                    ->toArray();
            } catch (\Throwable $e) {
                return [];
            }
        });

        $vendors->transform(function ($vendor) use ($counts) {
            $vendor->dids_count = $counts[$vendor->vendorid] ?? 0;
            return $vendor;
        });

        return view('vendors.index', compact('vendors'));
    }

    public function show($id)
    {
        $vendor = Vendor::findOrFail($id);
        
        // Use simplePaginate to avoid expensive COUNT(*) on 1.8M rows
        $dids = Did::where('GroupVendor', $vendor->vendorid)->orderBy('Id', 'desc')->simplePaginate(20);
        
        $cdrs = DB::table('cdrs_new')->where('trunk', 'LIKE', "%{$vendor->vendorname}%")->orderBy('id', 'desc')->limit(20)->get();

        return view('vendors.show', compact('vendor', 'dids', 'cdrs'));
    }
}
