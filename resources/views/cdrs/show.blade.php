@extends('layouts.app')

@section('title', "CDR #{$cdr->id} Details")

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-xs text-slate-500 font-medium mb-1">
        <a href="{{ route('cdrs.index') }}" class="text-blue-600 hover:underline flex items-center gap-1">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            <span>Back to CDRs</span>
        </a>
        <span>/</span>
        <span class="text-slate-800 font-semibold">Call Record Detail</span>
    </div>

    <div class="bg-white p-8 rounded-2xl border border-slate-200/90 shadow-xs space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-slate-100 pb-5 gap-3">
            <div>
                <span class="text-[11px] font-mono text-slate-400 font-bold tracking-wider">CDR LOG #{{ $cdr->id }}</span>
                <h1 class="text-xl font-bold text-slate-800 flex items-center gap-3 mt-1">
                    <span class="font-mono text-blue-600">{{ $cdr->callerid ?: 'Anonymous' }}</span>
                    <span class="text-slate-400 font-normal">&rarr;</span>
                    <span class="font-mono text-slate-800">{{ $cdr->callednum }}</span>
                </h1>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-semibold self-start sm:self-auto {{ $cdr->disposition_badge }}">
                {{ $cdr->disposition }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
            <div class="space-y-4">
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
                    <span class="text-slate-500 block font-semibold mb-1">Ring-To Destination:</span>
                    <span class="font-mono text-slate-800 font-bold break-all">{{ $cdr->ringto ?: 'Default Route' }}</span>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
                    <span class="text-slate-500 block font-semibold mb-1">Trunk / Gateway:</span>
                    <span class="text-slate-800 font-medium">{{ $cdr->trunk ?: 'Default SIP Trunk' }}</span>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
                    <span class="text-slate-500 block font-semibold mb-1">From IP Address:</span>
                    <span class="font-mono text-slate-700">{{ $cdr->FromIP ?: 'N/A' }}</span>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
                    <span class="text-slate-500 block font-semibold mb-1">Asterisk Channel:</span>
                    <span class="font-mono text-slate-600">{{ $cdr->channel ?: 'N/A' }}</span>
                </div>
            </div>

            <div class="space-y-4">
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
                    <span class="text-slate-500 block font-semibold mb-1">Billed Duration:</span>
                    <span class="text-slate-800 font-mono font-bold text-sm">{{ $cdr->duration_formatted }} ({{ $cdr->billseconds }} seconds)</span>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
                    <span class="text-slate-500 block font-semibold mb-1">Call Cost:</span>
                    <span class="text-emerald-600 font-mono font-bold text-sm">${{ number_format($cdr->billcost, 5) }}</span>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
                    <span class="text-slate-500 block font-semibold mb-1">Call Timestamp:</span>
                    <span class="text-slate-700 font-mono">{{ $cdr->callstart }}</span>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
                    <span class="text-slate-500 block font-semibold mb-1">Unique ID:</span>
                    <span class="font-mono text-slate-600 text-[11px] truncate block">{{ $cdr->uniqueid ?: 'N/A' }}</span>
                </div>
            </div>
        </div>

        @if($cdr->OID)
            <div class="border-t border-slate-100 pt-5 flex items-center justify-between">
                <span class="text-xs text-slate-500">Associated Customer Account:</span>
                <a href="{{ route('customers.show', $cdr->OID) }}" class="text-xs font-mono text-blue-600 hover:underline font-bold inline-flex items-center gap-1">
                    <span>Customer #{{ $cdr->OID }}</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
