@extends('layouts.app')

@section('title', 'Local Number Portability (LNP)')

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-xs text-slate-500 font-medium">
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline flex items-center gap-1">
            <i data-lucide="home" class="w-3.5 h-3.5"></i>
            <span>Dashboard</span>
        </a>
        <span>&gt;</span>
        <span class="text-slate-600">DIDs Management</span>
        <span>&gt;</span>
        <span class="text-slate-800 font-semibold">Number Porting (LNP)</span>
    </div>

    <!-- Header Card -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <i data-lucide="arrow-left-right" class="w-5 h-5"></i>
                </div>
                <span>Local Number Portability (LNP)</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1.5 ml-11.5">Manage port-in and port-out carrier orders, track numbers, and document verification</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1.5 rounded-xl bg-indigo-50 text-indigo-700 font-bold text-xs border border-indigo-100 flex items-center gap-1.5">
                <i data-lucide="inbox" class="w-3.5 h-3.5"></i>
                <span>{{ number_format($requests->total()) }} Porting Requests</span>
            </span>
        </div>
    </div>

    <!-- Search Form -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-xs">
        <form action="{{ route('lnp.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
            <div class="flex-1 relative">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Search by DID number, tracking reference, or customer OID..." 
                    class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:bg-white font-mono transition-all"
                >
            </div>
            <button type="submit" class="py-2 px-5 rounded-xl bg-[#0d244f] hover:bg-[#132c5b] text-white font-semibold text-xs flex items-center justify-center gap-1.5 transition-all shadow-sm">
                <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                <span>Filter</span>
            </button>
            @if(request('search'))
                <a href="{{ route('lnp.index') }}" class="py-2 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs flex items-center justify-center">
                    <i data-lucide="x" class="w-3.5 h-3.5"></i>
                </a>
            @endif
        </form>
    </div>

    <!-- LNP Requests Table -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs font-mono">
                <thead>
                    <tr class="bg-slate-50/75 text-slate-500 border-b border-slate-200 uppercase tracking-wider text-[10px] font-sans font-semibold">
                        <th class="py-3 px-4">LNP ID</th>
                        <th class="py-3 px-4">Porting DID Number</th>
                        <th class="py-3 px-4">Customer (OID)</th>
                        <th class="py-3 px-4">Tracking #</th>
                        <th class="py-3 px-4">Port Fee ($)</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Target Date</th>
                        <th class="py-3 px-4 text-right font-sans">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($requests as $req)
                        @php
                            $statusStyle = match((int)$req->Status) {
                                2 => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                1 => 'bg-blue-50 text-blue-700 border-blue-100',
                                3 => 'bg-rose-50 text-rose-700 border-rose-100',
                                default => 'bg-amber-50 text-amber-700 border-amber-100',
                            };
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-4 text-slate-400 font-bold">#{{ $req->ID }}</td>
                            <td class="py-3 px-4 font-bold text-blue-600">+{{ $req->DIDNumber }}</td>
                            <td class="py-3 px-4">
                                @if($req->OID)
                                    <a href="{{ route('customers.show', $req->OID) }}" class="text-blue-600 font-semibold hover:underline">
                                        {{ $req->OID }}
                                    </a>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-slate-700 font-mono">{{ $req->TrackNo ?: 'Pending Assign' }}</td>
                            <td class="py-3 px-4 text-emerald-600 font-bold">${{ number_format($req->Charges, 2) }}</td>
                            <td class="py-3 px-4 font-sans">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold border {{ $statusStyle }}">
                                    {{ $req->status_label }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-slate-500 font-sans text-[11px]">{{ $req->CompletionDate ?: ($req->Date ?: 'N/A') }}</td>
                            <td class="py-3 px-4 text-right font-sans">
                                <form action="{{ route('lnp.update', $req->ID) }}" method="POST" class="inline-flex items-center gap-1">
                                    @csrf
                                    @method('PUT')
                                    <select name="Status" onchange="this.form.submit()" class="px-2.5 py-1 bg-slate-50 border border-slate-300 rounded-lg text-xs text-slate-700 focus:outline-none focus:border-blue-500 font-sans">
                                        <option value="0" {{ $req->Status == 0 ? 'selected' : '' }}>Pending</option>
                                        <option value="1" {{ $req->Status == 1 ? 'selected' : '' }}>Processing</option>
                                        <option value="2" {{ $req->Status == 2 ? 'selected' : '' }}>Completed</option>
                                        <option value="3" {{ $req->Status == 3 ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400 font-sans text-xs">
                                No LNP requests currently in queue.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100 bg-slate-50/50">
            {{ $requests->links() }}
        </div>
    </div>
</div>
@endsection
