@extends('layouts.app')

@section('title', "Order #{$order->OID}")

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-xs text-slate-500 font-medium">
        <a href="{{ route('orders.index') }}" class="text-blue-600 hover:underline flex items-center gap-1">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            <span>Back to Orders</span>
        </a>
        <span>/</span>
        <span class="text-slate-800 font-semibold">Order Details</span>
    </div>

    <!-- Order Header Card -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <span class="text-[11px] text-slate-400 font-mono font-bold uppercase tracking-wider">ORDER REFERENCE</span>
            <h1 class="text-2xl font-black text-slate-800 font-mono mt-0.5">#{{ $order->OID }}</h1>
            <p class="text-xs text-slate-500 mt-1">{{ $order->PlanType ?: ($order->ProductType ?: 'Standard DID Provisioning') }}</p>
        </div>

        <div class="text-right">
            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                {{ $order->OrderStatus ?: 'Completed' }}
            </span>
            <div class="mt-2 text-2xl font-bold text-slate-800 font-mono">
                ${{ number_format($order->Price, 2) }}
            </div>
        </div>
    </div>

    <!-- Order Summary Grid -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-xs grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Customer Details</span>
            <p class="text-sm font-bold text-slate-800">{{ $order->customer->full_name ?? 'Customer' }}</p>
            <p class="text-xs text-blue-600 font-mono mt-1 font-semibold">OID: {{ $order->CustomerID }}</p>
            <a href="{{ route('customers.show', $order->CustomerID) }}" class="text-xs text-blue-600 hover:underline mt-2 inline-flex items-center gap-1 font-medium">
                <span>View Account</span>
                <i data-lucide="arrow-right" class="w-3 h-3"></i>
            </a>
        </div>

        <div>
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Financial Breakdown</span>
            <div class="text-xs space-y-1 text-slate-600">
                <div class="flex justify-between py-0.5 border-b border-slate-100"><span>Base Price:</span> <span class="font-mono text-slate-800 font-bold">${{ number_format($order->Price, 2) }}</span></div>
                <div class="flex justify-between py-0.5 border-b border-slate-100"><span>Setup Cost:</span> <span class="font-mono text-slate-800 font-bold">${{ number_format($order->SetupCost, 2) }}</span></div>
                <div class="flex justify-between py-0.5"><span>Security Deposit:</span> <span class="font-mono text-slate-800 font-bold">${{ number_format($order->SecurityDeposit, 2) }}</span></div>
            </div>
        </div>

        <div>
            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Payment Method</span>
            <p class="text-sm font-mono text-slate-800 font-bold">{{ $order->PaymentType ?: 'Prepaid Balance' }}</p>
            <p class="text-xs text-slate-500 mt-1">Promo Code: {{ $order->PromoCode ?: 'None' }}</p>
        </div>
    </div>

    <!-- Associated DIDs -->
    @if(count($dids) > 0)
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
            <div class="p-4 border-b border-slate-100">
                <h2 class="text-sm font-bold text-slate-800">Associated DIDs in this Order</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs font-mono">
                    <thead>
                        <tr class="bg-slate-50/75 text-slate-500 border-b border-slate-200 uppercase tracking-wider text-[10px] font-sans font-semibold">
                            <th class="py-3 px-4">DID Number</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Monthly MRC</th>
                            <th class="py-3 px-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($dids as $did)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-3 px-4 font-bold text-blue-600">+{{ $did->DIDNumber }}</td>
                                <td class="py-3 px-4 font-sans">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold {{ $did->status_badge_class }}">
                                        {{ $did->status_label }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-emerald-600 font-bold">${{ number_format($did->MonthlyCharges, 2) }}</td>
                                <td class="py-3 px-4 text-right font-sans">
                                    <a href="{{ route('dids.show', $did->Id) }}" class="p-1.5 text-slate-400 hover:text-blue-600 inline-block">
                                        <i data-lucide="external-link" class="w-4 h-4"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
