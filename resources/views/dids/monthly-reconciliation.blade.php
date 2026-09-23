@extends('layouts.app')

@section('title', 'Monthly Reconciliation')

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
        <span class="text-slate-800 font-semibold">Monthly Reconciliation</span>
    </div>

    <!-- Header Banner -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight flex items-center gap-2.5">
                <i data-lucide="calculator" class="w-6 h-6 text-indigo-600"></i>
                <span>Monthly Carrier MRC Reconciliation</span>
            </h1>
            <p class="text-xs text-slate-400 mt-0.5">Audit carrier vendor recurring costs against active customer billing revenue</p>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs font-mono">
                <thead>
                    <tr class="bg-slate-50/75 text-slate-500 border-b border-slate-200 uppercase tracking-wider text-[10px] font-sans font-semibold">
                        <th class="py-3 px-4">Carrier Vendor</th>
                        <th class="py-3 px-4 text-center">Active DIDs</th>
                        <th class="py-3 px-4 text-right">Customer Revenue (MRC)</th>
                        <th class="py-3 px-4 text-right">Vendor Cost (MRC)</th>
                        <th class="py-3 px-4 text-right">Estimated Gross Margin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($reconciliation as $row)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-4 font-sans font-semibold text-slate-800">
                                <a href="{{ route('vendors.show', $row->GroupVendor) }}" class="text-blue-600 hover:underline">
                                    Vendor #{{ $row->GroupVendor }}
                                </a>
                            </td>
                            <td class="py-3 px-4 text-center font-bold text-slate-700">{{ number_format($row->total_dids) }}</td>
                            <td class="py-3 px-4 text-right font-bold text-slate-900">${{ number_format($row->customer_mrc, 2) }}</td>
                            <td class="py-3 px-4 text-right text-slate-600">${{ number_format($row->vendor_mrc, 2) }}</td>
                            <td class="py-3 px-4 text-right font-bold text-emerald-600">${{ number_format($row->gross_margin, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400 font-sans text-xs">
                                No reconciliation data found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100 bg-slate-50/50">
            {{ $reconciliation->links() }}
        </div>
    </div>
</div>
@endsection
