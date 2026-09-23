<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CrmAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('crm_user')) {
            return redirect()->route('login')->with('warning', 'Please login to access the CRM.');
        }

        return $next($request);
    }
}
