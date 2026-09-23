<?php

namespace App\Http\Controllers;

use App\Models\Cdr;
use App\Models\Country;
use App\Models\Customer;
use App\Models\Did;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // Top Countries by available/allocated DIDs
        $countryStats = DB::table('CountriesAvail')
            ->select('CountryCode', 'CountryName')
            ->limit(15)
            ->get();

        // Top Trunks by CDR count
        $trunkStats = DB::table('cdrs_new')
            ->select('trunk', DB::raw('count(*) as total_calls'), DB::raw('sum(billseconds) as total_seconds'))
            ->whereNotNull('trunk')
            ->where('trunk', '!=', '')
            ->groupBy('trunk')
            ->orderBy('total_calls', 'desc')
            ->limit(10)
            ->get();

        // Disposition breakdown
        $dispositionStats = DB::table('cdrs_new')
            ->select('disposition', DB::raw('count(*) as count'))
            ->groupBy('disposition')
            ->orderBy('count', 'desc')
            ->limit(6)
            ->get();

        return view('reports.index', compact('countryStats', 'trunkStats', 'dispositionStats'));
    }
}
