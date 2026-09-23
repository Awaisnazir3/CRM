@extends('layouts.app')

@section('title', 'Signup Management - Customers')

@section('content')
<div class="space-y-6">
    <!-- Breadcrumbs & Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-500 font-medium mb-1">
                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a>
                <span>&gt;</span>
                <span class="text-slate-600">Signup Management</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800 flex items-center gap-2">
                <i data-lucide="users" class="w-6 h-6 text-blue-600"></i>
                <span>Customer Accounts CRM</span>
            </h1>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('customers.create') }}" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs flex items-center gap-1.5 transition-all shadow-md shadow-blue-600/20">
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                <span>New Registration</span>
            </a>
        </div>
    </div>

    <!-- Search Card -->
    <div class="p-4 rounded-2xl bg-white border border-slate-200/90 shadow-xs">
        <form action="{{ route('customers.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
            <div class="flex-1 relative">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Search by name, company, email, phone, UID, Customer ID..." 
                    class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-300 rounded-lg text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-500"
                >
            </div>
            <button type="submit" class="py-2 px-5 rounded-lg bg-[#0d244f] hover:bg-[#132c5b] text-white font-semibold text-xs flex items-center justify-center gap-1.5 transition-all">
                <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                <span>Search</span>
            </button>
            @if(request('search'))
                <a href="{{ route('customers.index') }}" class="py-2 px-3 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold flex items-center justify-center" title="Clear Search">
                    <i data-lucide="x" class="w-3.5 h-3.5"></i>
                </a>
            @endif
        </form>
    </div>

    <!-- Customer Table Card -->
    <div class="rounded-2xl bg-white border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-600 border-b border-slate-200 uppercase tracking-wider text-[10px]">
                        <th class="py-3 px-4 font-bold">UID / Account</th>
                        <th class="py-3 px-4 font-bold">Customer Name</th>
                        <th class="py-3 px-4 font-bold">Company</th>
                        <th class="py-3 px-4 font-bold">Email</th>
                        <th class="py-3 px-4 font-bold">Phone</th>
                        <th class="py-3 px-4 font-bold">Country / City</th>
                        <th class="py-3 px-4 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($customers as $customer)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-3 px-4 font-mono font-bold text-blue-600">
                                <a href="{{ route('customers.show', $customer->UID) }}" class="hover:underline">
                                    #{{ $customer->UID }}
                                </a>
                            </td>
                            <td class="py-3 px-4 font-semibold text-slate-800">
                                <a href="{{ route('customers.show', $customer->UID) }}" class="hover:text-blue-600">
                                    {{ $customer->full_name ?: 'Unnamed Account' }}
                                </a>
                            </td>
                            <td class="py-3 px-4 text-slate-600">{{ $customer->CCompany ?: 'Individual' }}</td>
                            <td class="py-3 px-4 text-slate-500 font-mono">{{ $customer->CEmail }}</td>
                            <td class="py-3 px-4 text-slate-500 font-mono">{{ $customer->CTelOff ?: ($customer->CCell ?: 'N/A') }}</td>
                            <td class="py-3 px-4 text-slate-600">
                                {{ $customer->address->Country ?? 'N/A' }}{{ isset($customer->address->City) && $customer->address->City ? ', ' . $customer->address->City : '' }}
                            </td>
                            <td class="py-3 px-4 text-right">
                                <a href="{{ route('customers.show', $customer->UID) }}" class="px-2.5 py-1 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-semibold inline-flex items-center gap-1 transition-all">
                                    <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                    <span>360° Profile</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400 text-xs">
                                No customer records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-200 flex items-center justify-between text-xs text-slate-500">
            <div>
                Showing {{ $customers->firstItem() ?? 0 }} to {{ $customers->lastItem() ?? 0 }} of {{ number_format($customers->total()) }} Customers
            </div>
            <div>
                {{ $customers->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
