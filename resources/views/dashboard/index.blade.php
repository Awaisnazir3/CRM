@extends('layouts.app')

@section('title', 'Dashboard - Admin Overview')

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-xs text-slate-500 font-medium">
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline flex items-center gap-1">
            <i data-lucide="home" class="w-3.5 h-3.5"></i>
            <span>Dashboard</span>
        </a>
        <span>&gt;</span>
        <span class="text-slate-600">Admin Overview</span>
    </div>

    <!-- Welcome Hero Card (Matching Screenshot) -->
    <div class="bg-white rounded-2xl p-6 md:p-8 border border-slate-200/90 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Dashboard</h1>
            <p class="text-base font-medium text-slate-600 mt-1">
                Welcome <span class="font-bold text-blue-600">{{ session('crm_user.name', 'Awais Nazeer') }}</span>
            </p>
            <p class="text-xs text-slate-400 italic mt-4">
                Wholesale Phone Numbers Solution For Internet Telephone Service Providers.
            </p>
        </div>

        <div>
            <button class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs flex items-center gap-2 transition-all shadow-md shadow-blue-600/20 active:scale-95">
                <i data-lucide="key" class="w-3.5 h-3.5"></i>
                <span>Change Password</span>
            </button>
        </div>
    </div>

    <!-- 12 Metric Cards Grid (4 columns x 3 rows - Exact Match to Screenshot) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- 1. Total Users -->
        <div class="stat-card p-5 flex flex-col justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#0d244f] text-white flex items-center justify-center shadow-xs">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">TOTAL USERS</span>
                    <span class="text-xl font-bold text-slate-800 font-sans block mt-0.5">38,886</span>
                </div>
            </div>
            <div class="mt-4 pt-2 border-t border-slate-100 flex items-center gap-1 text-[11px] text-emerald-600 font-medium">
                <span>&uarr; 555414.3% from last month</span>
            </div>
        </div>

        <!-- 2. Total Buyers -->
        <div class="stat-card p-5 flex flex-col justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-sky-500 text-white flex items-center justify-center shadow-xs">
                    <i data-lucide="user" class="w-5 h-5"></i>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">TOTAL BUYERS</span>
                    <span class="text-xl font-bold text-slate-800 font-sans block mt-0.5">37,014</span>
                </div>
            </div>
            <div class="mt-4 pt-2 border-t border-slate-100 flex items-center gap-1 text-[11px] text-emerald-600 font-medium">
                <span>&uarr; 1233700% from last month</span>
            </div>
        </div>

        <!-- 3. Total Vendors -->
        <div class="stat-card p-5 flex flex-col justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#132c5b] text-white flex items-center justify-center shadow-xs">
                    <i data-lucide="store" class="w-5 h-5"></i>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">TOTAL VENDORS</span>
                    <span class="text-xl font-bold text-slate-800 font-sans block mt-0.5">600</span>
                </div>
            </div>
            <div class="mt-4 pt-2 border-t border-slate-100 flex items-center gap-1 text-[11px] text-emerald-600 font-medium">
                <span>&uarr; 59900% from last month</span>
            </div>
        </div>

        <!-- 4. Suspended Accounts -->
        <div class="stat-card p-5 flex flex-col justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-rose-500 text-white flex items-center justify-center shadow-xs">
                    <i data-lucide="user-x" class="w-5 h-5"></i>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">SUSPENDED ACCOUNTS</span>
                    <span class="text-xl font-bold text-slate-800 font-sans block mt-0.5">60,721</span>
                </div>
            </div>
            <div class="mt-4 pt-2 border-t border-slate-100 flex items-center gap-1 text-[11px] text-emerald-600 font-medium">
                <span>&uarr; 4072000% from last month</span>
            </div>
        </div>

        <!-- 5. Overdue Payments -->
        <div class="stat-card p-5 flex flex-col justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-rose-500 text-white flex items-center justify-center shadow-xs">
                    <i data-lucide="alert-circle" class="w-5 h-5"></i>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">OVERDUE PAYMENTS</span>
                    <span class="text-xl font-bold text-slate-800 font-sans block mt-0.5">1,216</span>
                </div>
            </div>
            <div class="mt-4 pt-2 border-t border-slate-100 flex items-center gap-1 text-[11px] text-slate-500 font-medium">
                <span>$466,131 total due &bull; 122 suspended</span>
            </div>
        </div>

        <!-- 6. Payment Received -->
        <div class="stat-card p-5 flex flex-col justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center shadow-xs">
                    <i data-lucide="dollar-sign" class="w-5 h-5"></i>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">PAYMENT RECEIVED</span>
                    <span class="text-xl font-bold text-slate-800 font-sans block mt-0.5">$0.12M</span>
                </div>
            </div>
            <div class="mt-4 pt-2 border-t border-slate-100 flex items-center gap-1 text-[11px] text-emerald-600 font-medium">
                <span>&uarr; 100% from last month</span>
            </div>
        </div>

        <!-- 7. Complaints -->
        <div class="stat-card p-5 flex flex-col justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center shadow-xs">
                    <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">COMPLAINTS</span>
                    <span class="text-xl font-bold text-slate-800 font-sans block mt-0.5">{{ number_format($openTickets) }}</span>
                </div>
            </div>
            <div class="mt-4 pt-2 border-t border-slate-100 flex items-center gap-1 text-[11px] text-emerald-600 font-medium">
                <span>&uarr; 406.7% from last month</span>
            </div>
        </div>

        <!-- 8. New Contact Inquiries -->
        <div class="stat-card p-5 flex flex-col justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#0d244f] text-white flex items-center justify-center shadow-xs">
                    <i data-lucide="mail" class="w-5 h-5"></i>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">NEW CONTACT INQUIRIES</span>
                    <span class="text-xl font-bold text-slate-800 font-sans block mt-0.5">30</span>
                </div>
            </div>
            <div class="mt-4 pt-2 border-t border-slate-100 flex items-center gap-1 text-[11px] text-slate-500 font-medium">
                <i data-lucide="file-text" class="w-3 h-3 text-slate-400"></i>
                <span>Website quote & contact form</span>
            </div>
        </div>

        <!-- 9. Sales -->
        <div class="stat-card p-5 flex flex-col justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-sky-400 text-white flex items-center justify-center shadow-xs">
                    <i data-lucide="trending-up" class="w-5 h-5"></i>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">SALES</span>
                    <span class="text-xl font-bold text-slate-800 font-sans block mt-0.5">$6,630.78M</span>
                </div>
            </div>
            <div class="mt-4 pt-2 border-t border-slate-100 flex items-center gap-1 text-[11px] text-emerald-600 font-medium">
                <span>&uarr; 46269.1% from last month</span>
            </div>
        </div>

        <!-- 10. Pending Orders -->
        <div class="stat-card p-5 flex flex-col justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-slate-600 text-white flex items-center justify-center shadow-xs">
                    <i data-lucide="clock" class="w-5 h-5"></i>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">PENDING ORDERS</span>
                    <span class="text-xl font-bold text-slate-800 font-sans block mt-0.5">30,606</span>
                </div>
            </div>
            <div class="mt-4 pt-2 border-t border-slate-100 flex items-center gap-1 text-[11px] text-emerald-600 font-medium">
                <span>&uarr; 278136.4% from last month</span>
            </div>
        </div>

        <!-- 11. Document Approval -->
        <div class="stat-card p-5 flex flex-col justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-purple-400 text-white flex items-center justify-center shadow-xs">
                    <i data-lucide="file-check" class="w-5 h-5"></i>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">DOCUMENT APPROVAL</span>
                    <span class="text-xl font-bold text-slate-800 font-sans block mt-0.5">0</span>
                </div>
            </div>
            <div class="mt-4 pt-2 border-t border-slate-100 flex items-center gap-1 text-[11px] text-slate-500 font-medium">
                <i data-lucide="check" class="w-3 h-3 text-slate-400"></i>
                <span>No pending documents</span>
            </div>
        </div>

        <!-- 12. Credit Cards Approval -->
        <div class="stat-card p-5 flex flex-col justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-teal-500 text-white flex items-center justify-center shadow-xs">
                    <i data-lucide="credit-card" class="w-5 h-5"></i>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">CREDIT CARDS APPROVAL</span>
                    <span class="text-xl font-bold text-slate-800 font-sans block mt-0.5">75</span>
                </div>
            </div>
            <div class="mt-4 pt-2 border-t border-slate-100 flex items-center gap-1 text-[11px] text-slate-500 font-medium">
                <i data-lucide="clock" class="w-3 h-3 text-slate-400"></i>
                <span>Pending approval</span>
            </div>
        </div>
    </div>

    <!-- Live Data Sections Grid (Recent DIDs & Open Complaints) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent DIDs -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i data-lucide="phone" class="w-4 h-4 text-blue-600"></i>
                    <span>Recent DIDs Added</span>
                </h2>
                <a href="{{ route('dids.index') }}" class="text-xs text-blue-600 hover:underline font-semibold">View All &rarr;</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-slate-400 border-b border-slate-100 font-semibold">
                            <th class="pb-2.5">DID Number</th>
                            <th class="pb-2.5">Status</th>
                            <th class="pb-2.5">MRC ($)</th>
                            <th class="pb-2.5">Customer OID</th>
                            <th class="pb-2.5 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-mono">
                        @foreach($recentDids as $did)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-2.5 font-bold text-slate-800">+{{ $did->DIDNumber }}</td>
                                <td class="py-2.5 font-sans">
                                    <span class="px-2 py-0.5 rounded-md text-[11px] font-semibold {{ $did->status_badge_class }}">
                                        {{ $did->status_label }}
                                    </span>
                                </td>
                                <td class="py-2.5 text-emerald-600 font-semibold">${{ number_format($did->MonthlyCharges, 2) }}</td>
                                <td class="py-2.5 text-slate-600">{{ $did->OID ?: 'Unassigned' }}</td>
                                <td class="py-2.5 text-right font-sans">
                                    <a href="{{ route('dids.show', $did->Id) }}" class="p-1 text-slate-400 hover:text-blue-600 inline-block">
                                        <i data-lucide="settings" class="w-3.5 h-3.5"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Open Support Complaints -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i data-lucide="life-buoy" class="w-4 h-4 text-amber-500"></i>
                    <span>Priority Support Tickets</span>
                </h2>
                <a href="{{ route('tickets.index') }}" class="text-xs text-amber-600 hover:underline font-semibold">View All &rarr;</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-slate-400 border-b border-slate-100 font-semibold">
                            <th class="pb-2.5">Ticket ID</th>
                            <th class="pb-2.5">Summary</th>
                            <th class="pb-2.5">Customer</th>
                            <th class="pb-2.5">Date</th>
                            <th class="pb-2.5 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($recentTickets as $ticket)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-2.5 font-mono font-bold text-amber-600">#{{ $ticket->ComplainID }}</td>
                                <td class="py-2.5 text-slate-700 max-w-[180px] truncate">{{ Str::limit($ticket->Complain, 28) }}</td>
                                <td class="py-2.5 font-mono text-blue-600">{{ $ticket->UID }}</td>
                                <td class="py-2.5 text-slate-400 text-[11px]">{{ $ticket->DateTime ? \Carbon\Carbon::parse($ticket->DateTime)->diffForHumans() : 'Recently' }}</td>
                                <td class="py-2.5 text-right">
                                    <a href="{{ route('tickets.show', $ticket->ComplainID) }}" class="px-2 py-1 rounded bg-amber-50 text-amber-700 border border-amber-200 text-[11px] font-semibold hover:bg-amber-100 transition-all">
                                        Resolve
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
