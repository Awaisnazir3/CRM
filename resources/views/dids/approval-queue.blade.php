@extends('layouts.app')

@section('title', 'Approval Queue')

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
        <span class="text-slate-800 font-semibold">Approval Queue</span>
    </div>

    <!-- Header Banner -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight flex items-center gap-2.5">
                <i data-lucide="check-square" class="w-6 h-6 text-amber-500"></i>
                <span>KYC & Regulatory Approval Queue</span>
            </h1>
            <p class="text-xs text-slate-400 mt-0.5">DIDs requiring end-user identity documents, address verification, or regulatory clearance</p>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs font-mono">
                <thead>
                    <tr class="bg-slate-50/75 text-slate-500 border-b border-slate-200 uppercase tracking-wider text-[10px] font-sans font-semibold">
                        <th class="py-3 px-4">DID Number</th>
                        <th class="py-3 px-4">Country</th>
                        <th class="py-3 px-4">City</th>
                        <th class="py-3 px-4">Customer OID</th>
                        <th class="py-3 px-4">Verification Needed</th>
                        <th class="py-3 px-4 text-right font-sans">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pendingDids as $did)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-4 font-bold text-blue-600 font-mono">
                                <a href="{{ route('dids.show', $did->Id) }}" class="hover:underline">
                                    +{{ $did->DIDNumber }}
                                </a>
                            </td>
                            <td class="py-3 px-4 text-slate-800 font-sans font-medium">{{ $did->CountryN ?: 'International' }}</td>
                            <td class="py-3 px-4 text-slate-600 font-sans">{{ $did->City ?: 'Toll Free' }}</td>
                            <td class="py-3 px-4">
                                @if($did->OID)
                                    <a href="{{ route('customers.show', $did->OID) }}" class="text-indigo-600 font-bold hover:underline">
                                        #{{ $did->OID }}
                                    </a>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 font-sans">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-amber-50 text-amber-700 border border-amber-100">
                                    Proof of Identity / Address Required
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right font-sans">
                                <a href="{{ route('dids.show', $did->Id) }}" class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-[11px] font-semibold transition-all">
                                    Review Docs
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400 font-sans text-xs">
                                All DIDs are verified. No pending approval items.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100 bg-slate-50/50">
            {{ $pendingDids->links() }}
        </div>
    </div>
</div>
@endsection
