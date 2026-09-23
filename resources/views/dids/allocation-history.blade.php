@extends('layouts.app')

@section('title', 'Allocation History')

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
        <span class="text-slate-800 font-semibold">Allocation History</span>
    </div>

    <!-- Header Banner -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight flex items-center gap-2.5">
                <i data-lucide="history" class="w-6 h-6 text-blue-600"></i>
                <span>Allocation History</span>
            </h1>
            <p class="text-xs text-slate-400 mt-0.5">Comprehensive audit trail of customer DID allocations, purchases, and release actions</p>
        </div>

        <a href="{{ route('dids.allocate') }}" class="px-5 py-2.5 rounded-xl bg-[#0d244f] hover:bg-[#132c5b] text-white font-semibold text-xs flex items-center gap-2 transition-all shadow-sm">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>New Allocation</span>
        </a>
    </div>

    <!-- Search Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-xs">
        <form action="{{ route('dids.allocation-history') }}" method="GET" class="flex gap-3">
            <div class="flex-1 relative">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Search by DID Number, Customer OID, Activity, or Person..." 
                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:bg-white font-mono"
                >
            </div>
            <button type="submit" class="py-2.5 px-5 rounded-xl bg-[#0d244f] hover:bg-[#132c5b] text-white font-semibold text-xs flex items-center justify-center gap-1.5 transition-all shadow-sm">
                <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                <span>Filter</span>
            </button>
        </form>
    </div>

    <!-- History Table -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs font-mono">
                <thead>
                    <tr class="bg-slate-50/75 text-slate-500 border-b border-slate-200 uppercase tracking-wider text-[10px] font-sans font-semibold">
                        <th class="py-3 px-4">Record ID</th>
                        <th class="py-3 px-4">DID Number</th>
                        <th class="py-3 px-4">Buyer (OID)</th>
                        <th class="py-3 px-4">Activity</th>
                        <th class="py-3 px-4">Origin / Place</th>
                        <th class="py-3 px-4">Allocated By</th>
                        <th class="py-3 px-4 text-right">Date & Time</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($history as $item)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-4 text-slate-400 font-bold">#{{ $item->ID }}</td>
                            <td class="py-3 px-4 font-bold text-blue-600 font-mono">
                                <a href="{{ route('dids.index', ['search_did' => $item->DIDNumber]) }}" class="hover:underline">
                                    +{{ $item->DIDNumber }}
                                </a>
                            </td>
                            <td class="py-3 px-4">
                                @if($item->OID)
                                    <a href="{{ route('customers.show', $item->OID) }}" class="text-indigo-600 font-bold hover:underline">
                                        #{{ $item->OID }}
                                    </a>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 font-sans">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold {{ stripos($item->Activity, 'allocat') !== false || stripos($item->Activity, 'purch') !== false ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-slate-100 text-slate-700' }}">
                                    {{ $item->Activity ?: 'Action' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-slate-600 font-sans">{{ $item->Place ?: 'N/A' }}</td>
                            <td class="py-3 px-4 text-slate-800 font-medium font-sans">{{ $item->Person ?: 'System' }}</td>
                            <td class="py-3 px-4 text-right text-slate-500 text-[11px] font-sans">{{ $item->Date }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400 font-sans text-xs">
                                No allocation history records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100 bg-slate-50/50">
            {{ $history->links() }}
        </div>
    </div>
</div>
@endsection
