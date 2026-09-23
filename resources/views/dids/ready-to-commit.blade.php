@extends('layouts.app')

@section('title', 'Ready to Commit')

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
        <span class="text-slate-800 font-semibold">Ready to Commit</span>
    </div>

    <!-- Header Banner -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight flex items-center gap-2.5">
                <i data-lucide="send" class="w-6 h-6 text-emerald-600"></i>
                <span>Ready to Commit Inventory</span>
            </h1>
            <p class="text-xs text-slate-400 mt-0.5">Freshly uploaded vendor DIDs tested and ready for market activation</p>
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
                        <th class="py-3 px-4">Monthly Rate</th>
                        <th class="py-3 px-4">Carrier Vendor</th>
                        <th class="py-3 px-4">Offer Date</th>
                        <th class="py-3 px-4 text-right font-sans">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($commitDids as $did)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-4 font-bold text-blue-600 font-mono">
                                <a href="{{ route('dids.show', $did->Id) }}" class="hover:underline">
                                    +{{ $did->DIDNumber }}
                                </a>
                            </td>
                            <td class="py-3 px-4 text-slate-800 font-sans font-medium">{{ $did->CountryN ?: 'International' }}</td>
                            <td class="py-3 px-4 text-slate-600 font-sans">{{ $did->City ?: 'Toll Free' }}</td>
                            <td class="py-3 px-4 text-emerald-600 font-bold font-mono">${{ number_format($did->MonthlyCharges, 2) }}</td>
                            <td class="py-3 px-4 text-slate-700 font-sans">Vendor #{{ $did->GroupVendor }}</td>
                            <td class="py-3 px-4 text-slate-500 font-sans text-[11px]">{{ $did->OfferDate ?: 'Today' }}</td>
                            <td class="py-3 px-4 text-right font-sans">
                                <a href="{{ route('dids.allocate', ['did' => $did->DIDNumber]) }}" class="px-3 py-1 bg-[#0d244f] hover:bg-[#132c5b] text-white rounded-lg text-[11px] font-semibold transition-all">
                                    Allocate Now
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400 font-sans text-xs">
                                No uncommitted DIDs found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100 bg-slate-50/50">
            {{ $commitDids->links() }}
        </div>
    </div>
</div>
@endsection
