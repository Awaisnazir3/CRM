@extends('layouts.app')

@section('title', 'Payment Management')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-500 font-medium mb-1">
                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a>
                <span>&gt;</span>
                <span class="text-slate-600">Payment Management</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800 flex items-center gap-2">
                <i data-lucide="credit-card" class="w-6 h-6 text-blue-600"></i>
                <span>Payment Management & Ledgers</span>
            </h1>
        </div>

        <!-- Navigation Tabs -->
        <div class="flex items-center gap-2 overflow-x-auto">
            <a href="{{ route('billing.index', ['tab' => 'transactions']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-semibold {{ $tab === 'transactions' ? 'bg-[#0d244f] text-white font-bold' : 'bg-white text-slate-600 border border-slate-200 hover:text-slate-900' }}">
                44M+ Transactions
            </a>
            <a href="{{ route('billing.index', ['tab' => 'invoices']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-semibold {{ $tab === 'invoices' ? 'bg-blue-600 text-white font-bold' : 'bg-white text-slate-600 border border-slate-200 hover:text-slate-900' }}">
                Billing History
            </a>
            <a href="{{ route('billing.index', ['tab' => 'online']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-semibold {{ $tab === 'online' ? 'bg-purple-600 text-white font-bold' : 'bg-white text-slate-600 border border-slate-200 hover:text-slate-900' }}">
                Online Payments
            </a>
            <a href="{{ route('billing.index', ['tab' => 'paypal']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-semibold {{ $tab === 'paypal' ? 'bg-amber-600 text-white font-bold' : 'bg-white text-slate-600 border border-slate-200 hover:text-slate-900' }}">
                PayPal Authorize
            </a>
        </div>
    </div>

    @if($tab === 'transactions')
        <!-- Transactions Filter Card -->
        <div class="p-4 rounded-2xl bg-white border border-slate-200/90 shadow-xs">
            <form action="{{ route('billing.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                <input type="hidden" name="tab" value="transactions">

                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Customer / OID</label>
                    <input type="text" name="oid" value="{{ request('oid') }}" placeholder="Enter Customer OID" class="w-full px-3 py-1.5 bg-slate-50 border border-slate-300 rounded-lg text-xs text-slate-800 focus:outline-none focus:border-blue-500 font-mono">
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Search Ref / DID / Description</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search ledger..." class="w-full px-3 py-1.5 bg-slate-50 border border-slate-300 rounded-lg text-xs text-slate-800 focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Type</label>
                    <select name="type" class="w-full px-3 py-1.5 bg-slate-50 border border-slate-300 rounded-lg text-xs text-slate-700 focus:outline-none focus:border-blue-500">
                        <option value="">All Types</option>
                        <option value="CR" {{ request('type') == 'CR' ? 'selected' : '' }}>Credit (CR)</option>
                        <option value="DR" {{ request('type') == 'DR' ? 'selected' : '' }}>Debit (DR)</option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 py-1.5 px-4 rounded-lg bg-[#0d244f] hover:bg-[#132c5b] text-white font-semibold text-xs flex items-center justify-center gap-1.5 transition-all">
                        <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                        <span>Filter</span>
                    </button>
                    <a href="{{ route('billing.index') }}" class="py-1.5 px-3 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold flex items-center justify-center">
                        <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </form>
        </div>

        <!-- Transactions Table -->
        <div class="rounded-2xl bg-white border border-slate-200/90 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs font-mono">
                    <thead>
                        <tr class="bg-slate-50 text-slate-600 border-b border-slate-200 uppercase tracking-wider text-[10px] font-sans">
                            <th class="py-3 px-4 font-bold">Tx ID</th>
                            <th class="py-3 px-4 font-bold">Account (OID)</th>
                            <th class="py-3 px-4 font-bold">Type</th>
                            <th class="py-3 px-4 font-bold">Amount</th>
                            <th class="py-3 px-4 font-bold">Description</th>
                            <th class="py-3 px-4 font-bold">Reference / DID</th>
                            <th class="py-3 px-4 font-bold">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($records as $tx)
                            <tr class="hover:bg-slate-50/70">
                                <td class="py-3 px-4 text-slate-500 font-bold">#{{ $tx->TransactionID }}</td>
                                <td class="py-3 px-4 text-blue-600 font-bold">
                                    <a href="{{ route('customers.show', $tx->OID) }}" class="hover:underline">
                                        {{ $tx->OID }}
                                    </a>
                                </td>
                                <td class="py-3 px-4 font-sans">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-semibold {{ $tx->IsCredit ? 'badge-emerald' : 'badge-rose' }}">
                                        {{ $tx->IsCredit ? 'Credit' : 'Debit' }} ({{ $tx->Type }})
                                    </span>
                                </td>
                                <td class="py-3 px-4 font-bold text-sm {{ $tx->IsCredit ? 'text-emerald-600' : 'text-rose-600' }}">
                                    {{ $tx->IsCredit ? '+' : '-' }}${{ number_format($tx->Amount, 2) }}
                                </td>
                                <td class="py-3 px-4 text-slate-700 font-sans max-w-[260px] truncate" title="{{ $tx->Description }}">{{ $tx->Description }}</td>
                                <td class="py-3 px-4 text-slate-600">{{ $tx->DIDID ?: ($tx->ReferenceID ?: '-') }}</td>
                                <td class="py-3 px-4 text-slate-400 font-sans text-[11px]">{{ $tx->Date }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-slate-400 font-sans text-xs">
                                    No transaction records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-slate-200">
                {{ $records->links() }}
            </div>
        </div>

    @elseif($tab === 'invoices')
        <!-- Invoices Table -->
        <div class="rounded-2xl bg-white border border-slate-200/90 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs font-mono">
                    <thead>
                        <tr class="bg-slate-50 text-slate-600 border-b border-slate-200 uppercase tracking-wider text-[10px] font-sans">
                            <th class="py-3 px-4 font-bold">Transaction ID</th>
                            <th class="py-3 px-4 font-bold">Bill ID</th>
                            <th class="py-3 px-4 font-bold">Account (Customer)</th>
                            <th class="py-3 px-4 font-bold">Balance</th>
                            <th class="py-3 px-4 font-bold">Comments</th>
                            <th class="py-3 px-4 font-bold">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($records as $inv)
                            <tr class="hover:bg-slate-50/70">
                                <td class="py-3 px-4 text-slate-500">#{{ $inv->TID }}</td>
                                <td class="py-3 px-4 text-blue-600 font-bold">#{{ $inv->BID }}</td>
                                <td class="py-3 px-4 text-blue-600">
                                    <a href="{{ route('customers.show', $inv->AccountNo) }}" class="hover:underline">
                                        {{ $inv->AccountNo }}
                                    </a>
                                </td>
                                <td class="py-3 px-4 text-emerald-600 font-bold">${{ number_format($inv->Balance, 2) }}</td>
                                <td class="py-3 px-4 text-slate-700 font-sans">{{ $inv->Comments }}</td>
                                <td class="py-3 px-4 text-slate-400 font-sans text-[11px]">{{ $inv->Date }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400 font-sans text-xs">No billing history found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-slate-200">
                {{ $records->links() }}
            </div>
        </div>

    @elseif($tab === 'online')
        <!-- Online Payments Table -->
        <div class="rounded-2xl bg-white border border-slate-200/90 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs font-mono">
                    <thead>
                        <tr class="bg-slate-50 text-slate-600 border-b border-slate-200 uppercase tracking-wider text-[10px] font-sans">
                            <th class="py-3 px-4 font-bold">Payment ID</th>
                            <th class="py-3 px-4 font-bold">Account (OID)</th>
                            <th class="py-3 px-4 font-bold">Amount</th>
                            <th class="py-3 px-4 font-bold">Payer / Company</th>
                            <th class="py-3 px-4 font-bold">Email</th>
                            <th class="py-3 px-4 font-bold">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($records as $pay)
                            <tr class="hover:bg-slate-50/70">
                                <td class="py-3 px-4 text-purple-600 font-bold">#{{ $pay->ID }}</td>
                                <td class="py-3 px-4 text-blue-600 font-bold">
                                    <a href="{{ route('customers.show', $pay->OID) }}" class="hover:underline">
                                        {{ $pay->OID }}
                                    </a>
                                </td>
                                <td class="py-3 px-4 text-emerald-600 font-bold text-sm">${{ number_format($pay->amount, 2) }}</td>
                                <td class="py-3 px-4 text-slate-800 font-sans">{{ $pay->gfname }} {{ $pay->glname }} {{ $pay->company ? "({$pay->company})" : '' }}</td>
                                <td class="py-3 px-4 text-slate-500">{{ $pay->gmail }}</td>
                                <td class="py-3 px-4 text-slate-400 font-sans text-[11px]">{{ $pay->Date }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400 font-sans text-xs">No online payment logs found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-slate-200">
                {{ $records->links() }}
            </div>
        </div>

    @elseif($tab === 'paypal')
        <!-- PayPal Authorize Table -->
        <div class="rounded-2xl bg-white border border-slate-200/90 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs font-mono">
                    <thead>
                        <tr class="bg-slate-50 text-slate-600 border-b border-slate-200 uppercase tracking-wider text-[10px] font-sans">
                            <th class="py-3 px-4 font-bold">ID</th>
                            <th class="py-3 px-4 font-bold">Account (OID)</th>
                            <th class="py-3 px-4 font-bold">PayPal Tx ID</th>
                            <th class="py-3 px-4 font-bold">Amount</th>
                            <th class="py-3 px-4 font-bold">Approved By</th>
                            <th class="py-3 px-4 font-bold">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($records as $pp)
                            <tr class="hover:bg-slate-50/70">
                                <td class="py-3 px-4 text-amber-600 font-bold">#{{ $pp->ID }}</td>
                                <td class="py-3 px-4 text-blue-600 font-bold">
                                    <a href="{{ route('customers.show', $pp->OID) }}" class="hover:underline">
                                        {{ $pp->OID }}
                                    </a>
                                </td>
                                <td class="py-3 px-4 text-slate-700">{{ $pp->PayPalID }}</td>
                                <td class="py-3 px-4 text-emerald-600 font-bold text-sm">${{ number_format($pp->Amount, 2) }}</td>
                                <td class="py-3 px-4 text-slate-600 font-sans">{{ $pp->ApprovedBy ?: ($pp->Admin ?: 'Automated') }}</td>
                                <td class="py-3 px-4 text-slate-400 font-sans text-[11px]">{{ $pp->date }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400 font-sans text-xs">No PayPal authorization logs found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-slate-200">
                {{ $records->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
