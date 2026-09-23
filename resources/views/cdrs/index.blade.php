@extends('layouts.app')

@section('title', 'CDR & Call Logs')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-500 font-medium mb-1">
                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a>
                <span>&gt;</span>
                <span class="text-slate-600">CDR & Call Logs</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800 flex items-center gap-2">
                <i data-lucide="activity" class="w-6 h-6 text-blue-600"></i>
                <span>VoIP Call Detail Records (CDRs)</span>
            </h1>
        </div>
    </div>

    <!-- Search & Filter Card -->
    <div class="p-4 rounded-2xl bg-white border border-slate-200/90 shadow-xs">
        <form action="{{ route('cdrs.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <div>
                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Caller / Destination Number</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search phone numbers..." class="w-full px-3 py-1.5 bg-slate-50 border border-slate-300 rounded-lg text-xs text-slate-800 focus:outline-none focus:border-blue-500 font-mono">
            </div>

            <div>
                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Call Disposition</label>
                <select name="disposition" class="w-full px-3 py-1.5 bg-slate-50 border border-slate-300 rounded-lg text-xs text-slate-700 focus:outline-none focus:border-blue-500">
                    <option value="">All Dispositions</option>
                    <option value="ANSWERED" {{ request('disposition') == 'ANSWERED' ? 'selected' : '' }}>ANSWERED</option>
                    <option value="NO ANSWER" {{ request('disposition') == 'NO ANSWER' ? 'selected' : '' }}>NO ANSWER</option>
                    <option value="BUSY" {{ request('disposition') == 'BUSY' ? 'selected' : '' }}>BUSY</option>
                    <option value="FAILED" {{ request('disposition') == 'FAILED' ? 'selected' : '' }}>FAILED</option>
                </select>
            </div>

            <div>
                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Trunk Gateway</label>
                <input type="text" name="trunk" value="{{ request('trunk') }}" placeholder="Trunk name..." class="w-full px-3 py-1.5 bg-slate-50 border border-slate-300 rounded-lg text-xs text-slate-800 focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Customer / OID</label>
                <input type="text" name="oid" value="{{ request('oid') }}" placeholder="Customer OID" class="w-full px-3 py-1.5 bg-slate-50 border border-slate-300 rounded-lg text-xs text-slate-800 focus:outline-none focus:border-blue-500 font-mono">
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 py-1.5 px-4 rounded-lg bg-[#0d244f] hover:bg-[#132c5b] text-white font-semibold text-xs flex items-center justify-center gap-1.5 transition-all">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                    <span>Filter CDRs</span>
                </button>
                <a href="{{ route('cdrs.index') }}" class="py-1.5 px-3 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold flex items-center justify-center">
                    <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- CDRs Table -->
    <div class="rounded-2xl bg-white border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs font-mono">
                <thead>
                    <tr class="bg-slate-50 text-slate-600 border-b border-slate-200 uppercase tracking-wider text-[10px] font-sans">
                        <th class="py-3 px-4 font-bold">CDR ID</th>
                        <th class="py-3 px-4 font-bold">Caller ID</th>
                        <th class="py-3 px-4 font-bold">Destination Number</th>
                        <th class="py-3 px-4 font-bold">Ring-To URL</th>
                        <th class="py-3 px-4 font-bold">Duration</th>
                        <th class="py-3 px-4 font-bold">Cost ($)</th>
                        <th class="py-3 px-4 font-bold">Disposition</th>
                        <th class="py-3 px-4 font-bold">Call Start Time</th>
                        <th class="py-3 px-4 font-bold text-right font-sans">View</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($cdrs as $cdr)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-3 px-4 text-slate-500 font-bold">#{{ $cdr->id }}</td>
                            <td class="py-3 px-4 text-slate-800 font-bold">{{ $cdr->callerid ?: 'Anonymous' }}</td>
                            <td class="py-3 px-4 text-blue-600 font-bold">{{ $cdr->callednum }}</td>
                            <td class="py-3 px-4 text-slate-500 truncate max-w-[150px]" title="{{ $cdr->ringto }}">{{ $cdr->ringto }}</td>
                            <td class="py-3 px-4 text-slate-800 font-bold">{{ $cdr->duration_formatted }}</td>
                            <td class="py-3 px-4 text-emerald-600 font-semibold">${{ number_format($cdr->billcost, 4) }}</td>
                            <td class="py-3 px-4 font-sans">
                                <span class="px-2 py-0.5 rounded text-[10px] font-semibold {{ $cdr->disposition_badge }}">
                                    {{ $cdr->disposition }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-slate-400 font-sans text-[11px]">{{ $cdr->callstart }}</td>
                            <td class="py-3 px-4 text-right font-sans">
                                <a href="{{ route('cdrs.show', $cdr->id) }}" class="p-1 text-slate-400 hover:text-blue-600 inline-block">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-8 text-center text-slate-400 font-sans text-xs">
                                No Call Detail Records found matching criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-200">
            {{ $cdrs->links() }}
        </div>
    </div>
</div>
@endsection
