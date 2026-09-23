@extends('layouts.app')

@section('title', 'Ticket Management')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-500 font-medium mb-1">
                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a>
                <span>&gt;</span>
                <span class="text-slate-600">Ticket Management</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800 flex items-center gap-2">
                <i data-lucide="life-buoy" class="w-6 h-6 text-blue-600"></i>
                <span>Customer Complaints & Support Desk</span>
            </h1>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('tickets.create') }}" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs flex items-center gap-1.5 transition-all shadow-md shadow-blue-600/20">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Open New Ticket</span>
            </a>
        </div>
    </div>

    <!-- Status Tabs -->
    <div class="flex items-center gap-2 overflow-x-auto pb-2 border-b border-slate-200">
        <a href="{{ route('tickets.index', ['status' => 'open']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-semibold flex items-center gap-2 transition-all {{ $status === 'open' ? 'bg-amber-600 text-white font-bold' : 'bg-white text-slate-600 border border-slate-200 hover:text-slate-900' }}">
            <span>Open Tickets</span>
            <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $status === 'open' ? 'bg-white/20 text-white font-mono' : 'bg-amber-50 text-amber-700 font-mono' }}">{{ number_format($openCount) }}</span>
        </a>

        <a href="{{ route('tickets.index', ['status' => 'resolved']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-semibold flex items-center gap-2 transition-all {{ $status === 'resolved' ? 'bg-emerald-600 text-white font-bold' : 'bg-white text-slate-600 border border-slate-200 hover:text-slate-900' }}">
            <span>Resolved</span>
            <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $status === 'resolved' ? 'bg-white/20 text-white font-mono' : 'bg-emerald-50 text-emerald-700 font-mono' }}">{{ number_format($resolvedCount) }}</span>
        </a>

        <a href="{{ route('tickets.index', ['status' => 'all']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-semibold flex items-center gap-2 transition-all {{ $status === 'all' ? 'bg-[#0d244f] text-white font-bold' : 'bg-white text-slate-600 border border-slate-200 hover:text-slate-900' }}">
            <span>All Tickets</span>
            <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $status === 'all' ? 'bg-white/20 text-white font-mono' : 'bg-slate-100 text-slate-600 font-mono' }}">{{ number_format($totalCount) }}</span>
        </a>
    </div>

    <!-- Search Form -->
    <div class="p-4 rounded-2xl bg-white border border-slate-200/90 shadow-xs">
        <form action="{{ route('tickets.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
            <input type="hidden" name="status" value="{{ $status }}">
            <div class="flex-1 relative">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Search by Ticket ID, message content, customer UID, or DID number..." 
                    class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-300 rounded-lg text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-500"
                >
            </div>
            <button type="submit" class="py-2 px-5 rounded-lg bg-[#0d244f] hover:bg-[#132c5b] text-white font-semibold text-xs flex items-center justify-center gap-1.5 transition-all">
                <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                <span>Search</span>
            </button>
        </form>
    </div>

    <!-- Tickets Table -->
    <div class="rounded-2xl bg-white border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-600 border-b border-slate-200 uppercase tracking-wider text-[10px]">
                        <th class="py-3 px-4 font-bold">Ticket ID</th>
                        <th class="py-3 px-4 font-bold">Subject / Complaint Summary</th>
                        <th class="py-3 px-4 font-bold">Customer (UID)</th>
                        <th class="py-3 px-4 font-bold">Associated DID</th>
                        <th class="py-3 px-4 font-bold">Status</th>
                        <th class="py-3 px-4 font-bold">Assigned To</th>
                        <th class="py-3 px-4 font-bold">Date Created</th>
                        <th class="py-3 px-4 font-bold text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($tickets as $ticket)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-3 px-4 font-mono font-bold text-amber-600">
                                <a href="{{ route('tickets.show', $ticket->ComplainID) }}" class="hover:underline">
                                    #{{ $ticket->ComplainID }}
                                </a>
                            </td>
                            <td class="py-3 px-4 text-slate-800 max-w-[280px] truncate" title="{{ $ticket->Complain }}">
                                {{ $ticket->Complain }}
                            </td>
                            <td class="py-3 px-4 font-mono text-blue-600">
                                <a href="{{ route('customers.show', $ticket->UID) }}" class="hover:underline">
                                    {{ $ticket->UID }}
                                </a>
                            </td>
                            <td class="py-3 px-4 font-mono text-slate-700">{{ $ticket->DID ?: '-' }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded text-[11px] font-semibold {{ $ticket->status_badge }}">
                                    {{ $ticket->status_label }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-slate-500">{{ $ticket->Assign ?: 'Unassigned' }}</td>
                            <td class="py-3 px-4 text-slate-400 text-[11px]">{{ $ticket->DateTime ? \Carbon\Carbon::parse($ticket->DateTime)->format('M d, Y H:i') : 'N/A' }}</td>
                            <td class="py-3 px-4 text-right">
                                <a href="{{ route('tickets.show', $ticket->ComplainID) }}" class="px-2.5 py-1 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 text-xs font-semibold inline-flex items-center gap-1 transition-all">
                                    <i data-lucide="message-square" class="w-3.5 h-3.5"></i>
                                    <span>Thread</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-8 text-center text-slate-400 text-xs">
                                No support tickets found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-200">
            {{ $tickets->links() }}
        </div>
    </div>
</div>
@endsection
