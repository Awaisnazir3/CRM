@extends('layouts.app')

@section('title', 'Reports & Telecom Analytics')

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-xs text-slate-500 font-medium">
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline flex items-center gap-1">
            <i data-lucide="home" class="w-3.5 h-3.5"></i>
            <span>Dashboard</span>
        </a>
        <span>&gt;</span>
        <span class="text-slate-600">Finance & Reports</span>
        <span>&gt;</span>
        <span class="text-slate-800 font-semibold">Telecom Analytics</span>
    </div>

    <!-- Header Banner Card -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <i data-lucide="bar-chart-3" class="w-5 h-5"></i>
                </div>
                <span>Reports & Telecom Analytics</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1.5 ml-11.5">Aggregate traffic trends, DID geographic distribution, and trunk carrier metrics</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('cdrs.index') }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs flex items-center gap-2 transition-all">
                <i data-lucide="phone-call" class="w-3.5 h-3.5 text-slate-500"></i>
                <span>CDR Call Logs</span>
            </a>
            <a href="{{ route('billing.index') }}" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs flex items-center gap-2 transition-all shadow-md shadow-blue-600/20">
                <i data-lucide="dollar-sign" class="w-3.5 h-3.5"></i>
                <span>Billing History</span>
            </a>
        </div>
    </div>

    <!-- Disposition Summary Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($dispositionStats as $stat)
            @php
                $disp = strtoupper($stat->disposition ?: 'OTHER');
                $isAnswered = in_array($disp, ['ANSWER', 'ANSWERED']);
                $isBusy = in_array($disp, ['BUSY']);
                $isCongestion = in_array($disp, ['CONGESTION', 'CHANUNAVAIL']);
                $isCancel = in_array($disp, ['CANCEL', 'NO ANSWER']);
                
                $badgeBg = $isAnswered ? 'bg-emerald-50 text-emerald-600' : ($isBusy ? 'bg-amber-50 text-amber-600' : ($isCancel ? 'bg-rose-50 text-rose-600' : 'bg-slate-100 text-slate-600'));
                $numberColor = $isAnswered ? 'text-emerald-600' : 'text-slate-800';
            @endphp
            <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs hover:border-slate-300 transition-all flex flex-col justify-between">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block font-sans">
                        {{ $stat->disposition ?: 'OTHER' }}
                    </span>
                    <span class="w-6 h-6 rounded-lg {{ $badgeBg }} flex items-center justify-center text-[10px] font-bold">
                        <i data-lucide="{{ $isAnswered ? 'check' : ($isCancel ? 'x' : 'activity') }}" class="w-3.5 h-3.5"></i>
                    </span>
                </div>
                <div class="mt-1">
                    <span class="text-2xl font-bold font-mono {{ $numberColor }}">
                        {{ number_format($stat->count) }}
                    </span>
                    <span class="text-[10px] text-slate-400 block mt-0.5">Total Records</span>
                </div>
            </div>
        @endforeach
    </div>

    <!-- 2 Column Analytics Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Trunk Gateways by Call Volume -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-xs">
            <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center">
                        <i data-lucide="server" class="w-4 h-4"></i>
                    </div>
                    <span>Top Trunk Gateways by CDR Traffic</span>
                </h2>
                <span class="text-xs text-slate-400 font-medium">{{ count($trunkStats) }} Gateways</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-slate-500 border-b border-slate-200 font-semibold">
                            <th class="pb-3 px-2">Trunk Gateway</th>
                            <th class="pb-3 px-2 text-right">Total Calls</th>
                            <th class="pb-3 px-2 text-right">Total Duration</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($trunkStats as $t)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-3 px-2 text-slate-800 font-bold font-mono">{{ $t->trunk ?: 'Unknown' }}</td>
                                <td class="py-3 px-2 text-right text-blue-600 font-bold font-mono">{{ number_format($t->total_calls) }}</td>
                                <td class="py-3 px-2 text-right text-slate-600 font-mono">{{ number_format(floor(($t->total_seconds ?? 0) / 60)) }} mins</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-8 text-center text-slate-400">No trunk data found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Geographic DID Inventory Availability -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-xs">
            <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <i data-lucide="globe" class="w-4 h-4"></i>
                    </div>
                    <span>Country Codes Available</span>
                </h2>
                <span class="text-xs text-slate-400 font-medium">Top Coverage</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-slate-500 border-b border-slate-200 font-semibold">
                            <th class="pb-3 px-2">Country Code</th>
                            <th class="pb-3 px-2">Country Name</th>
                            <th class="pb-3 px-2 text-right">Explore</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($countryStats as $c)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-3 px-2 font-mono text-blue-600 font-bold">+{{ $c->CountryCode }}</td>
                                <td class="py-3 px-2 text-slate-800 font-medium">{{ $c->CountryName }}</td>
                                <td class="py-3 px-2 text-right">
                                    <a href="{{ route('dids.index') }}?search={{ $c->CountryCode }}" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 font-semibold text-xs hover:underline">
                                        <span>View DIDs</span>
                                        <i data-lucide="arrow-right" class="w-3 h-3"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-8 text-center text-slate-400">No country data found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
