@extends('layouts.app')

@section('title', 'SIP Trunks & Gateway Nodes')

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-xs text-slate-500 font-medium">
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline flex items-center gap-1">
            <i data-lucide="home" class="w-3.5 h-3.5"></i>
            <span>Dashboard</span>
        </a>
        <span>&gt;</span>
        <span class="text-slate-600">Table Migration & SIP</span>
        <span>&gt;</span>
        <span class="text-slate-800 font-semibold">SIP Trunks & Nodes</span>
    </div>

    <!-- Header Card -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                    <i data-lucide="server" class="w-5 h-5"></i>
                </div>
                <span>SIP Trunks & Gateway Nodes</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1.5 ml-11.5">Manage Asterisk / OpenSIPS / FreeSWITCH buddy trunks and routing servers</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1.5 rounded-xl bg-purple-50 text-purple-700 font-bold text-xs border border-purple-100 flex items-center gap-1.5">
                <i data-lucide="activity" class="w-3.5 h-3.5"></i>
                <span>{{ number_format($buddies->total()) }} Active SIP Buddies</span>
            </span>
        </div>
    </div>

    <!-- Search Form -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-xs">
        <form action="{{ route('servers.index') }}" method="GET" class="flex gap-3">
            <div class="flex-1 relative">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Search SIP buddy by name, caller ID, host IP, or context..." 
                    class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:bg-white transition-all"
                >
            </div>
            <button type="submit" class="py-2 px-5 rounded-xl bg-[#0d244f] hover:bg-[#132c5b] text-white font-semibold text-xs flex items-center justify-center gap-1.5 transition-all shadow-sm">
                <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                <span>Filter</span>
            </button>
            @if(request('search'))
                <a href="{{ route('servers.index') }}" class="py-2 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs flex items-center justify-center">
                    <i data-lucide="x" class="w-3.5 h-3.5"></i>
                </a>
            @endif
        </form>
    </div>

    <!-- SIP Buddies Table -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="p-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                <span>Registered SIP Buddies & Trunks</span>
                <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-xs font-mono">{{ number_format($buddies->total()) }}</span>
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs font-mono">
                <thead>
                    <tr class="bg-slate-50/75 text-slate-500 border-b border-slate-200 uppercase tracking-wider text-[10px] font-sans font-semibold">
                        <th class="py-3 px-4">ID</th>
                        <th class="py-3 px-4">Buddy Name / Account</th>
                        <th class="py-3 px-4">Caller ID</th>
                        <th class="py-3 px-4">Host / IP</th>
                        <th class="py-3 px-4">Context</th>
                        <th class="py-3 px-4">DTMF Mode</th>
                        <th class="py-3 px-4">NAT</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($buddies as $buddy)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-4 text-slate-400 font-bold">#{{ $buddy->id }}</td>
                            <td class="py-3 px-4 text-blue-600 font-bold font-sans">{{ $buddy->name }}</td>
                            <td class="py-3 px-4 text-slate-800 font-sans">{{ $buddy->callerid ?: 'Default' }}</td>
                            <td class="py-3 px-4 text-slate-600 font-mono">{{ $buddy->host ?: ($buddy->defaultip ?: 'dynamic') }}</td>
                            <td class="py-3 px-4 text-slate-600 font-sans">{{ $buddy->context ?: 'default' }}</td>
                            <td class="py-3 px-4 text-slate-600 font-sans">{{ $buddy->dtmfmode ?: 'rfc2833' }}</td>
                            <td class="py-3 px-4 font-sans">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold {{ $buddy->nat ? 'bg-blue-50 text-blue-700 border border-blue-100' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $buddy->nat ?: 'No NAT' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400 font-sans text-xs">
                                No SIP buddy trunk records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100 bg-slate-50/50">
            {{ $buddies->links() }}
        </div>
    </div>
</div>
@endsection
