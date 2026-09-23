@extends('layouts.app')

@section('title', 'Orders & Provisioning')

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-xs text-slate-500 font-medium">
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline flex items-center gap-1">
            <i data-lucide="home" class="w-3.5 h-3.5"></i>
            <span>Dashboard</span>
        </a>
        <span>&gt;</span>
        <span class="text-slate-600">Payment Management</span>
        <span>&gt;</span>
        <span class="text-slate-800 font-semibold">Orders & Provisioning</span>
    </div>

    <!-- Header Card -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                </div>
                <span>Orders & Provisioning</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1.5 ml-11.5">Track single and bulk DID purchases, recurring subscriptions, and provisioning queues</p>
        </div>

        <div class="flex items-center gap-2 bg-slate-100 p-1 rounded-xl">
            <a href="{{ route('orders.index', ['type' => 'standard']) }}" class="px-4 py-1.5 rounded-lg text-xs font-semibold transition-all {{ $type === 'standard' ? 'bg-white text-slate-800 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Standard Orders
            </a>
            <a href="{{ route('orders.index', ['type' => 'bulk']) }}" class="px-4 py-1.5 rounded-lg text-xs font-semibold transition-all {{ $type === 'bulk' ? 'bg-[#0d244f] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Bulk Orders ({{ count($orders) }})
            </a>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50/75 text-slate-500 border-b border-slate-200 uppercase tracking-wider text-[10px] font-sans font-semibold">
                        <th class="py-3 px-4">Order ID</th>
                        <th class="py-3 px-4">Customer / OID</th>
                        <th class="py-3 px-4">{{ $type === 'bulk' ? 'Quantity' : 'Product / Plan' }}</th>
                        <th class="py-3 px-4">Total Price</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-mono">
                    @forelse($orders as $order)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-4 font-bold text-blue-600">#{{ $order->OID ?? $order->ID }}</td>
                            <td class="py-3 px-4">
                                @if(isset($order->CustomerID) || isset($order->OID))
                                    <a href="{{ route('customers.show', $order->CustomerID ?? $order->OID) }}" class="text-blue-600 font-semibold hover:underline">
                                        {{ $order->CustomerID ?? $order->OID }}
                                    </a>
                                @else
                                    <span class="text-slate-400">Unspecified</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 font-sans text-slate-800 font-medium">
                                {{ $type === 'bulk' ? ($order->Qty . ' Numbers') : ($order->PlanType ?: ($order->ProductType ?: 'Standard DID Order')) }}
                            </td>
                            <td class="py-3 px-4 text-emerald-600 font-bold">
                                ${{ number_format($order->Price ?? ($order->Funds ?? 0), 2) }}
                            </td>
                            <td class="py-3 px-4 font-sans">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                    {{ $order->OrderStatus ?? 'Completed' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right font-sans">
                                @if($type === 'standard')
                                    <a href="{{ route('orders.show', $order->OID) }}" class="px-3 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold inline-flex items-center gap-1 transition-all">
                                        <i data-lucide="eye" class="w-3.5 h-3.5 text-slate-500"></i>
                                        <span>Details</span>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400 font-sans text-xs">
                                No orders found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100 bg-slate-50/50">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
