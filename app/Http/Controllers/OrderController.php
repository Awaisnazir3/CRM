<?php

namespace App\Http\Controllers;

use App\Models\BulkOrder;
use App\Models\Did;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type', 'standard');
        
        if ($type === 'bulk') {
            $orders = BulkOrder::with('customer')->orderBy('ID', 'desc')->paginate(20)->withQueryString();
        } else {
            $query = Order::with('customer');
            if ($search = $request->input('search')) {
                $query->where('OID', 'LIKE', "%{$search}%")
                      ->orWhere('CustomerID', 'LIKE', "%{$search}%");
            }
            if ($status = $request->input('status')) {
                $query->where('OrderStatus', $status);
            }
            $orders = $query->orderBy('OID', 'desc')->paginate(20)->withQueryString();
        }

        return view('orders.index', compact('orders', 'type'));
    }

    public function show($oid)
    {
        $order = Order::with('customer')->where('OID', $oid)->firstOrFail();
        $dids = Did::where('OID', $order->CustomerID)->orWhere('OID', $order->OID)->limit(20)->get();
        return view('orders.show', compact('order', 'dids'));
    }
}
