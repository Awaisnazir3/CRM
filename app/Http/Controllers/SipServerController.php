<?php

namespace App\Http\Controllers;

use App\Models\SipBuddy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SipServerController extends Controller
{
    public function index(Request $request)
    {
        $query = SipBuddy::query();

        if ($search = $request->input('search')) {
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('callerid', 'LIKE', "%{$search}%")
                  ->orWhere('host', 'LIKE', "%{$search}%")
                  ->orWhere('fromuser', 'LIKE', "%{$search}%");
        }

        $buddies = $query->orderBy('id', 'desc')->paginate(20)->withQueryString();
        $serverList = DB::table('ServerList')->get();

        return view('servers.index', compact('buddies', 'serverList'));
    }
}
