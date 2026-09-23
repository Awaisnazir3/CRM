@extends('layouts.app')

@section('title', 'Requested DIDs')

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-xs text-slate-500 font-medium">
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline flex items-center gap-1">
            <i data-lucide="home" class="w-3.5 h-3.5"></i>
            <span>Dashboard</span>
        </a>
        <span>&gt;</span>
        <a href="{{ route('dids.index') }}" class="text-blue-600 hover:underline">DIDs Management</a>
        <span>&gt;</span>
        <span class="text-slate-800 font-semibold">Requested DIDs</span>
    </div>

    <!-- Header Banner -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight flex items-center gap-2.5">
                <i data-lucide="inbox" class="w-6 h-6 text-blue-600"></i>
                <span>Requested DIDs & Backorders</span>
            </h1>
            <p class="text-xs text-slate-400 mt-0.5">Manage customer demand for specific country / area code backorder requests</p>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs font-mono">
                <thead>
                    <tr class="bg-slate-50/75 text-slate-500 border-b border-slate-200 uppercase tracking-wider text-[10px] font-sans font-semibold">
                        <th class="py-3 px-4">Request ID</th>
                        <th class="py-3 px-4">Customer OID</th>
                        <th class="py-3 px-4">Country Code</th>
                        <th class="py-3 px-4">Area Code</th>
                        <th class="py-3 px-4">Quantity</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Date Requested</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($backorders as $item)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-4 text-slate-400 font-bold">#{{ $item->ID }}</td>
                            <td class="py-3 px-4">
                                <a href="{{ route('customers.show', $item->OID) }}" class="text-blue-600 font-bold hover:underline">
                                    #{{ $item->OID }}
                                </a>
                            </td>
                            <td class="py-3 px-4 text-slate-800 font-bold font-mono">+{{ $item->CountryCode }}</td>
                            <td class="py-3 px-4 text-slate-700 font-mono">{{ $item->AreaCode ?: 'Any' }}</td>
                            <td class="py-3 px-4 text-indigo-600 font-bold font-mono">{{ $item->Quantity }} DIDs</td>
                            <td class="py-3 px-4 font-sans">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-amber-50 text-amber-700 border border-amber-100">
                                    {{ $item->Status == 1 ? 'Pending Vendor Fulfillment' : 'Completed' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right text-slate-500 font-sans text-[11px]">{{ $item->Date }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400 font-sans text-xs">
                                No pending backorder requests in queue.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100 bg-slate-50/50">
            {{ $backorders->links() }}
        </div>
    </div>
</div>
@endsection
