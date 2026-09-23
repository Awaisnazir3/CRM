@extends('layouts.app')

@section('title', 'Vendors Management')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-500 font-medium mb-1">
                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a>
                <span>&gt;</span>
                <span class="text-slate-600">Vendors Management</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800 flex items-center gap-2">
                <i data-lucide="store" class="w-6 h-6 text-blue-600"></i>
                <span>Carrier Vendors & Trunks</span>
            </h1>
        </div>
    </div>

    <!-- Vendor Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($vendors as $vendor)
            <div class="p-6 rounded-2xl bg-white border border-slate-200/90 shadow-xs hover:shadow-md transition-all flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="w-9 h-9 rounded-xl bg-blue-50 border border-blue-200 text-blue-700 font-black text-sm flex items-center justify-center font-mono">
                            #{{ $vendor->vendorid }}
                        </span>
                        <span class="px-2 py-0.5 rounded text-[11px] font-semibold badge-emerald">Active Carrier</span>
                    </div>

                    <h2 class="text-base font-bold text-slate-800 group-hover:text-blue-600 transition-colors">
                        {{ $vendor->vendorname }}
                    </h2>
                    <p class="text-xs text-slate-500 mt-1">
                        {{ $vendor->description ?: 'Wholesale Telecom Carrier' }}
                    </p>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                    <div>
                        <span class="text-slate-400 block text-[10px] uppercase font-semibold">Total Supplied DIDs</span>
                        <span class="font-mono font-bold text-blue-600 text-sm">{{ number_format($vendor->dids_count) }}</span>
                    </div>

                    <a href="{{ route('vendors.show', $vendor->vendorid) }}" class="px-3.5 py-1.5 rounded-xl bg-slate-50 hover:bg-blue-50 text-slate-700 hover:text-blue-700 border border-slate-200 text-xs font-semibold flex items-center gap-1 transition-all">
                        <span>Trunk Details</span>
                        <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
