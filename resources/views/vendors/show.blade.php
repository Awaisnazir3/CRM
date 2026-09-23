@extends('layouts.app')

@section('title', "Carrier Vendor - {$vendor->vendorname}")

@section('content')
<div class="space-y-6">
    <!-- Breadcrumbs -->
    <div class="flex items-center gap-2 text-xs text-slate-500 font-medium mb-1">
        <a href="{{ route('vendors.index') }}" class="text-blue-600 hover:underline flex items-center gap-1">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            <span>Back to Carriers</span>
        </a>
        <span>&gt;</span>
        <span class="text-slate-600">Carrier Details</span>
    </div>

    <!-- Vendor Header -->
    <div class="p-6 rounded-2xl bg-white border border-slate-200/90 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <span class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-200 text-blue-700 font-bold text-base flex items-center justify-center font-mono">
                    #{{ $vendor->vendorid }}
                </span>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">{{ $vendor->vendorname }}</h1>
                    <p class="text-xs text-slate-500">{{ $vendor->description ?: 'Wholesale Telecom Provider' }}</p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3 font-mono text-xs">
            <div class="px-3.5 py-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-700">
                <span class="text-slate-400 block text-[10px] uppercase font-sans font-semibold">Loaded DIDs</span>
                <span class="text-blue-600 font-bold text-base">{{ $dids->count() }}</span>
            </div>
        </div>
    </div>

    <!-- Carrier DIDs Table -->
    <div class="rounded-2xl bg-white border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="p-4 border-b border-slate-100">
            <h2 class="text-sm font-bold text-slate-800">DIDs Sourced from this Carrier</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-600 border-b border-slate-200 uppercase tracking-wider text-[10px]">
                        <th class="py-3 px-4 font-bold">DID Number</th>
                        <th class="py-3 px-4 font-bold">Status</th>
                        <th class="py-3 px-4 font-bold">Customer OID</th>
                        <th class="py-3 px-4 font-bold">Monthly Cost</th>
                        <th class="py-3 px-4 font-bold">Per Min Cost</th>
                        <th class="py-3 px-4 font-bold text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-mono">
                    @forelse($dids as $did)
                        <tr class="hover:bg-slate-50/70">
                            <td class="py-3 px-4 font-bold text-slate-900">+{{ $did->DIDNumber }}</td>
                            <td class="py-3 px-4 font-sans">
                                <span class="px-2 py-0.5 rounded-md text-[11px] font-semibold {{ $did->status_badge_class }}">
                                    {{ $did->status_label }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-blue-600">{{ $did->OID ?: 'None' }}</td>
                            <td class="py-3 px-4 text-emerald-600 font-semibold">${{ number_format($did->MonthlyCharges, 2) }}</td>
                            <td class="py-3 px-4 text-slate-600">${{ number_format($did->PerMinuteCharges, 4) }}</td>
                            <td class="py-3 px-4 text-right font-sans">
                                <a href="{{ route('dids.show', $did->Id) }}" class="p-1 text-slate-400 hover:text-blue-600">
                                    <i data-lucide="external-link" class="w-4 h-4"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 font-sans text-xs">
                                No DIDs linked to this carrier.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-200">
            {{ $dids->links() }}
        </div>
    </div>
</div>
@endsection
