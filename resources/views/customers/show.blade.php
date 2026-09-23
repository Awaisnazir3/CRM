@extends('layouts.app')

@section('title', "Customer #{$customer->UID} - {$customer->full_name}")

@section('content')
<div class="space-y-6" x-data="{ currentTab: 'dids' }">
    <!-- Breadcrumbs & Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-500 font-medium mb-1">
                <a href="{{ route('customers.index') }}" class="text-blue-600 hover:underline flex items-center gap-1">
                    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                    <span>Back to Customer Directory</span>
                </a>
                <span>&gt;</span>
                <span class="text-slate-600">Customer 360° Profile</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800 flex items-center gap-3">
                <span>{{ $customer->full_name ?: 'Account #' . $customer->UID }}</span>
                <span class="px-2.5 py-0.5 rounded-md text-xs font-mono font-bold bg-blue-50 text-blue-700 border border-blue-200">
                    UID: {{ $customer->UID }}
                </span>
            </h1>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('tickets.create') }}?uid={{ $customer->UID }}" class="px-3.5 py-2 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 text-xs font-semibold flex items-center gap-1.5 transition-all">
                <i data-lucide="ticket" class="w-4 h-4"></i>
                <span>Open Ticket</span>
            </a>
            <a href="{{ route('dids.create') }}?oid={{ $customer->CustomerID }}" class="px-3.5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs flex items-center gap-1.5 transition-all shadow-md shadow-blue-600/20">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Assign DID</span>
            </a>
        </div>
    </div>

    <!-- Customer Overview Card -->
    <div class="p-6 rounded-2xl bg-white border border-slate-200/90 shadow-xs grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Company / Organization</span>
            <p class="text-sm font-bold text-slate-800">{{ $customer->CCompany ?: 'Individual Subscriber' }}</p>
            <p class="text-xs text-slate-500 mt-1 font-mono">Cust ID: {{ $customer->CustomerID }}</p>
        </div>

        <div>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Contact Email</span>
            <p class="text-sm font-semibold text-blue-600 font-mono">{{ $customer->CEmail }}</p>
            <p class="text-xs text-slate-500 mt-1 font-mono">Web: {{ $customer->CWebSite ?: 'N/A' }}</p>
        </div>

        <div>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Telephone</span>
            <p class="text-sm font-semibold text-slate-800 font-mono">{{ $customer->CTelOff ?: ($customer->CCell ?: 'N/A') }}</p>
            <p class="text-xs text-slate-500 mt-1 font-mono">Cell: {{ $customer->CCell ?: 'N/A' }}</p>
        </div>

        <div>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Physical Address</span>
            <p class="text-xs text-slate-600">
                {{ $customer->address ? $customer->address->formatted_address : 'Address not on file' }}
            </p>
        </div>
    </div>

    <!-- Interactive Navigation Tabs -->
    <div class="flex items-center gap-2 overflow-x-auto pb-2 border-b border-slate-200">
        <button 
            @click="currentTab = 'dids'" 
            :class="currentTab === 'dids' ? 'bg-[#0d244f] text-white font-bold' : 'bg-white text-slate-600 hover:text-slate-900 border border-slate-200'"
            class="px-4 py-2 rounded-xl text-xs font-semibold flex items-center gap-2 transition-all"
        >
            <i data-lucide="phone-call" class="w-3.5 h-3.5"></i>
            <span>Assigned DIDs</span>
            <span class="px-1.5 py-0.2 rounded-full text-[10px] bg-white/20 font-mono">{{ $dids->total() }}</span>
        </button>

        <button 
            @click="currentTab = 'orders'" 
            :class="currentTab === 'orders' ? 'bg-blue-600 text-white font-bold' : 'bg-white text-slate-600 hover:text-slate-900 border border-slate-200'"
            class="px-4 py-2 rounded-xl text-xs font-semibold flex items-center gap-2 transition-all"
        >
            <i data-lucide="shopping-bag" class="w-3.5 h-3.5"></i>
            <span>Orders</span>
            <span class="px-1.5 py-0.2 rounded-full text-[10px] bg-white/20 font-mono">{{ count($orders) }}</span>
        </button>

        <button 
            @click="currentTab = 'transactions'" 
            :class="currentTab === 'transactions' ? 'bg-emerald-600 text-white font-bold' : 'bg-white text-slate-600 hover:text-slate-900 border border-slate-200'"
            class="px-4 py-2 rounded-xl text-xs font-semibold flex items-center gap-2 transition-all"
        >
            <i data-lucide="receipt" class="w-3.5 h-3.5"></i>
            <span>Billing & Payments</span>
            <span class="px-1.5 py-0.2 rounded-full text-[10px] bg-white/20 font-mono">{{ count($transactions) }}</span>
        </button>

        <button 
            @click="currentTab = 'tickets'" 
            :class="currentTab === 'tickets' ? 'bg-amber-600 text-white font-bold' : 'bg-white text-slate-600 hover:text-slate-900 border border-slate-200'"
            class="px-4 py-2 rounded-xl text-xs font-semibold flex items-center gap-2 transition-all"
        >
            <i data-lucide="life-buoy" class="w-3.5 h-3.5"></i>
            <span>Support Tickets</span>
            <span class="px-1.5 py-0.2 rounded-full text-[10px] bg-white/20 font-mono">{{ count($tickets) }}</span>
        </button>

        <button 
            @click="currentTab = 'cdrs'" 
            :class="currentTab === 'cdrs' ? 'bg-purple-600 text-white font-bold' : 'bg-white text-slate-600 hover:text-slate-900 border border-slate-200'"
            class="px-4 py-2 rounded-xl text-xs font-semibold flex items-center gap-2 transition-all"
        >
            <i data-lucide="activity" class="w-3.5 h-3.5"></i>
            <span>Call Records</span>
            <span class="px-1.5 py-0.2 rounded-full text-[10px] bg-white/20 font-mono">{{ count($cdrs) }}</span>
        </button>

        <button 
            @click="currentTab = 'docs'" 
            :class="currentTab === 'docs' ? 'bg-indigo-600 text-white font-bold' : 'bg-white text-slate-600 hover:text-slate-900 border border-slate-200'"
            class="px-4 py-2 rounded-xl text-xs font-semibold flex items-center gap-2 transition-all"
        >
            <i data-lucide="file-check" class="w-3.5 h-3.5"></i>
            <span>KYC Compliance Docs</span>
            <span class="px-1.5 py-0.2 rounded-full text-[10px] bg-white/20 font-mono">{{ count($docs) }}</span>
        </button>
    </div>

    <!-- Tab 1 Content: Assigned DIDs -->
    <div x-show="currentTab === 'dids'" class="rounded-2xl bg-white border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="p-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-sm font-bold text-slate-800">Assigned DID Numbers</h2>
            <span class="text-xs text-slate-500 font-mono">{{ $dids->total() }} Total Assigned</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-600 border-b border-slate-200 uppercase tracking-wider text-[10px]">
                        <th class="py-3 px-4 font-bold">DID Number</th>
                        <th class="py-3 px-4 font-bold">Status</th>
                        <th class="py-3 px-4 font-bold">Monthly MRC</th>
                        <th class="py-3 px-4 font-bold">Setup NRC</th>
                        <th class="py-3 px-4 font-bold">Per Min</th>
                        <th class="py-3 px-4 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-mono">
                    @forelse($dids as $did)
                        <tr class="hover:bg-slate-50/70">
                            <td class="py-3 px-4 font-bold text-slate-900 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                <a href="{{ route('dids.show', $did->Id) }}" class="hover:text-blue-600">
                                    +{{ $did->DIDNumber }}
                                </a>
                            </td>
                            <td class="py-3 px-4 font-sans">
                                <span class="px-2 py-0.5 rounded-md text-[11px] font-semibold {{ $did->status_badge_class }}">
                                    {{ $did->status_label }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-emerald-600 font-semibold">${{ number_format($did->MonthlyCharges, 2) }}</td>
                            <td class="py-3 px-4 text-slate-600">${{ number_format($did->SetupCost, 2) }}</td>
                            <td class="py-3 px-4 text-slate-500">${{ number_format($did->PerMinuteCharges, 4) }}</td>
                            <td class="py-3 px-4 text-right font-sans">
                                <a href="{{ route('dids.show', $did->Id) }}" class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-blue-50 text-slate-700 hover:text-blue-700 border border-slate-200 text-xs font-semibold inline-flex items-center gap-1 transition-all">
                                    <i data-lucide="settings" class="w-3.5 h-3.5"></i>
                                    <span>Configure</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 font-sans text-xs">
                                No active DIDs assigned to this customer account.
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

    <!-- Tab 2 Content: Orders -->
    <div x-show="currentTab === 'orders'" class="rounded-2xl bg-white border border-slate-200/90 shadow-xs overflow-hidden" style="display: none;">
        <div class="p-4 border-b border-slate-100">
            <h2 class="text-sm font-bold text-slate-800">Order History</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-600 border-b border-slate-200 uppercase tracking-wider text-[10px]">
                        <th class="py-3 px-4 font-bold">Order ID</th>
                        <th class="py-3 px-4 font-bold">Product / Plan</th>
                        <th class="py-3 px-4 font-bold">Price</th>
                        <th class="py-3 px-4 font-bold">Setup Cost</th>
                        <th class="py-3 px-4 font-bold">Status</th>
                        <th class="py-3 px-4 font-bold text-right">View</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-mono">
                    @forelse($orders as $order)
                        <tr class="hover:bg-slate-50/70">
                            <td class="py-3 px-4 font-bold text-blue-600">#{{ $order->OID }}</td>
                            <td class="py-3 px-4 font-sans text-slate-800">{{ $order->PlanType ?: ($order->ProductType ?: 'DID Order') }}</td>
                            <td class="py-3 px-4 text-emerald-600 font-semibold">${{ number_format($order->Price, 2) }}</td>
                            <td class="py-3 px-4 text-slate-600">${{ number_format($order->SetupCost, 2) }}</td>
                            <td class="py-3 px-4 font-sans">
                                <span class="px-2 py-0.5 rounded text-[11px] font-semibold badge-blue">
                                    {{ $order->OrderStatus ?: 'Completed' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right font-sans">
                                <a href="{{ route('orders.show', $order->OID) }}" class="p-1 text-slate-400 hover:text-blue-600">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 font-sans text-xs">
                                No order records for this customer.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tab 3 Content: Transactions -->
    <div x-show="currentTab === 'transactions'" class="rounded-2xl bg-white border border-slate-200/90 shadow-xs overflow-hidden" style="display: none;">
        <div class="p-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-sm font-bold text-slate-800">Recent Transactions & Ledger Entries</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-600 border-b border-slate-200 uppercase tracking-wider text-[10px]">
                        <th class="py-3 px-4 font-bold">Tx ID</th>
                        <th class="py-3 px-4 font-bold">Type</th>
                        <th class="py-3 px-4 font-bold">Amount</th>
                        <th class="py-3 px-4 font-bold">Description</th>
                        <th class="py-3 px-4 font-bold">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-mono">
                    @forelse($transactions as $tx)
                        <tr class="hover:bg-slate-50/70">
                            <td class="py-3 px-4 text-slate-500">#{{ $tx->TransactionID }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-sans font-semibold {{ $tx->IsCredit ? 'badge-emerald' : 'badge-rose' }}">
                                    {{ $tx->IsCredit ? 'Credit' : 'Debit' }} ({{ $tx->Type }})
                                </span>
                            </td>
                            <td class="py-3 px-4 font-bold {{ $tx->IsCredit ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $tx->IsCredit ? '+' : '-' }}${{ number_format($tx->Amount, 2) }}
                            </td>
                            <td class="py-3 px-4 text-slate-700 font-sans truncate max-w-[200px]">{{ $tx->Description }}</td>
                            <td class="py-3 px-4 text-slate-400 font-sans text-[11px]">{{ $tx->Date }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400 font-sans text-xs">
                                No recent ledger transactions found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tab 4 Content: Support Tickets -->
    <div x-show="currentTab === 'tickets'" class="rounded-2xl bg-white border border-slate-200/90 shadow-xs overflow-hidden" style="display: none;">
        <div class="p-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-sm font-bold text-slate-800">Support & Complaints History</h2>
            <a href="{{ route('tickets.create') }}?uid={{ $customer->UID }}" class="text-xs text-blue-600 hover:underline">+ New Ticket</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-600 border-b border-slate-200 uppercase tracking-wider text-[10px]">
                        <th class="py-3 px-4 font-bold">Ticket ID</th>
                        <th class="py-3 px-4 font-bold">Subject / Description</th>
                        <th class="py-3 px-4 font-bold">Status</th>
                        <th class="py-3 px-4 font-bold">Date</th>
                        <th class="py-3 px-4 font-bold text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($tickets as $ticket)
                        <tr class="hover:bg-slate-50/70">
                            <td class="py-3 px-4 font-mono font-bold text-amber-600">#{{ $ticket->ComplainID }}</td>
                            <td class="py-3 px-4 text-slate-800 max-w-[250px] truncate">{{ $ticket->Complain }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded text-[11px] font-semibold {{ $ticket->status_badge }}">
                                    {{ $ticket->status_label }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-slate-400 text-[11px]">{{ $ticket->DateTime }}</td>
                            <td class="py-3 px-4 text-right">
                                <a href="{{ route('tickets.show', $ticket->ComplainID) }}" class="px-2.5 py-1 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 text-xs font-semibold transition-all">
                                    Open
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400 text-xs">
                                No support tickets logged for this customer.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tab 5 Content: Call Records -->
    <div x-show="currentTab === 'cdrs'" class="rounded-2xl bg-white border border-slate-200/90 shadow-xs overflow-hidden" style="display: none;">
        <div class="p-4 border-b border-slate-100">
            <h2 class="text-sm font-bold text-slate-800">Call Detail Records (CDRs)</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs font-mono">
                <thead>
                    <tr class="bg-slate-50 text-slate-600 border-b border-slate-200 uppercase tracking-wider text-[10px] font-sans">
                        <th class="py-3 px-4 font-bold">Caller</th>
                        <th class="py-3 px-4 font-bold">Destination</th>
                        <th class="py-3 px-4 font-bold">Duration</th>
                        <th class="py-3 px-4 font-bold">Status</th>
                        <th class="py-3 px-4 font-bold">Date Time</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($cdrs as $cdr)
                        <tr class="hover:bg-slate-50/70">
                            <td class="py-3 px-4 font-bold text-slate-800">{{ $cdr->callerid ?: 'Anonymous' }}</td>
                            <td class="py-3 px-4 text-blue-600">{{ $cdr->callednum }}</td>
                            <td class="py-3 px-4 text-slate-700">{{ $cdr->duration_formatted }}</td>
                            <td class="py-3 px-4 font-sans">
                                <span class="px-2 py-0.5 rounded text-[10px] font-semibold {{ $cdr->disposition_badge }}">
                                    {{ $cdr->disposition }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-slate-400 text-sans text-[11px]">{{ $cdr->callstart }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400 font-sans text-xs">
                                No call detail records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tab 6 Content: KYC Docs -->
    <div x-show="currentTab === 'docs'" class="rounded-2xl bg-white border border-slate-200/90 shadow-xs overflow-hidden" style="display: none;">
        <div class="p-4 border-b border-slate-100">
            <h2 class="text-sm font-bold text-slate-800">KYC & Compliance Verification Documents</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-600 border-b border-slate-200 uppercase tracking-wider text-[10px]">
                        <th class="py-3 px-4 font-bold">Doc ID</th>
                        <th class="py-3 px-4 font-bold">Document Type</th>
                        <th class="py-3 px-4 font-bold">Associated DID</th>
                        <th class="py-3 px-4 font-bold">Customer / Company</th>
                        <th class="py-3 px-4 font-bold">Status</th>
                        <th class="py-3 px-4 font-bold">Submission Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($docs as $doc)
                        <tr class="hover:bg-slate-50/70">
                            <td class="py-3 px-4 font-mono text-indigo-600 font-bold">#{{ $doc->ID }}</td>
                            <td class="py-3 px-4 font-semibold text-slate-800">{{ $doc->Type ?: ($doc->Doc ?: 'Identification Document') }}</td>
                            <td class="py-3 px-4 font-mono text-blue-600">{{ $doc->DID ?: 'Account KYC' }}</td>
                            <td class="py-3 px-4 text-slate-600">{{ $doc->CustomerName ?: $customer->full_name }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-semibold {{ $doc->Status == 1 ? 'badge-emerald' : 'badge-amber' }}">
                                    {{ $doc->Status == 1 ? 'Approved / Verified' : 'Pending Verification' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-slate-400 text-[11px]">{{ $doc->Date }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 text-xs">
                                No compliance documents uploaded for this account.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
