@extends('layouts.app')

@section('title', 'DIDs Management')

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-xs text-slate-500 font-medium">
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline flex items-center gap-1">
            <i data-lucide="home" class="w-3.5 h-3.5"></i>
            <span>Dashboard</span>
        </a>
        <span>&gt;</span>
        <span class="text-slate-800 font-semibold">DIDs Management</span>
    </div>

    <!-- Page Header (Matching Screenshot 1) -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight flex items-center gap-2.5">
                <i data-lucide="phone-call" class="w-6 h-6 text-blue-600"></i>
                <span>DIDs Management</span>
            </h1>
            <p class="text-sm font-semibold text-slate-700 mt-1">Manage All DIDs</p>
            <p class="text-xs text-slate-400 mt-0.5">View, filter, and manage all DID numbers with detailed information.</p>
        </div>

        <div>
            <a href="{{ route('dids.allocate') }}" class="px-5 py-2.5 rounded-xl bg-[#0d244f] hover:bg-[#132c5b] text-white font-semibold text-xs flex items-center gap-2 transition-all shadow-md shadow-slate-900/10 active:scale-95">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Allocate DID</span>
            </a>
        </div>
    </div>

    <!-- 5 Stat Cards (Matching Screenshot 1) -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
        <!-- 1. Total DIDs -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center">
                    <i data-lucide="phone" class="w-4 h-4"></i>
                </div>
                <div>
                    <span class="text-2xl font-bold font-sans text-slate-800">{{ number_format($stats['total']) }}</span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mt-0.5">TOTAL DIDS</span>
                </div>
            </div>
        </div>

        <!-- 2. Sold -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/90 border-t-2 border-t-emerald-500 shadow-xs flex flex-col justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                </div>
                <div>
                    <span class="text-2xl font-bold font-sans text-slate-800">{{ number_format($stats['sold']) }}</span>
                    <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider block mt-0.5">SOLD</span>
                </div>
            </div>
        </div>

        <!-- 3. Suspended -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/90 border-t-2 border-t-amber-500 shadow-xs flex flex-col justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <i data-lucide="alert-circle" class="w-4 h-4"></i>
                </div>
                <div>
                    <span class="text-2xl font-bold font-sans text-slate-800">{{ number_format($stats['suspended']) }}</span>
                    <span class="text-[10px] font-bold text-amber-600 uppercase tracking-wider block mt-0.5">SUSPENDED</span>
                </div>
            </div>
        </div>

        <!-- 4. Available -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/90 border-t-2 border-t-purple-500 shadow-xs flex flex-col justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                    <i data-lucide="package" class="w-4 h-4"></i>
                </div>
                <div>
                    <span class="text-2xl font-bold font-sans text-slate-800">{{ number_format($stats['available']) }}</span>
                    <span class="text-[10px] font-bold text-purple-600 uppercase tracking-wider block mt-0.5">AVAILABLE</span>
                </div>
            </div>
        </div>

        <!-- 5. Aging -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/90 border-t-2 border-t-rose-500 shadow-xs flex flex-col justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                    <i data-lucide="alert-triangle" class="w-4 h-4"></i>
                </div>
                <div>
                    <span class="text-2xl font-bold font-sans text-slate-800">{{ number_format($stats['aging']) }}</span>
                    <span class="text-[10px] font-bold text-rose-600 uppercase tracking-wider block mt-0.5">AGING</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Search Form (Matching Screenshot 1) -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs space-y-4">
        <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
            <i data-lucide="filter" class="w-4 h-4 text-slate-700"></i>
            <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Filters & Search</h2>
        </div>

        <form action="{{ route('dids.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-3">
                <!-- DID Number -->
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">DID Number</label>
                    <input 
                        type="text" 
                        name="search_did" 
                        value="{{ request('search_did', request('search')) }}" 
                        placeholder="Search by DID number..." 
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:bg-white font-mono"
                    >
                </div>

                <!-- Country -->
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Country</label>
                    <select name="country" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-xs text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white">
                        <option value="">All Countries</option>
                        @foreach($countries as $c)
                            <option value="{{ $c->CountryName }}" {{ request('country') == $c->CountryName ? 'selected' : '' }}>
                                {{ $c->CountryName }} (+{{ $c->CountryCode }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Status</label>
                    <select name="status" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-xs text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white">
                        <option value="all">All Status</option>
                        <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Available</option>
                        <option value="sold" {{ request('status') === 'sold' ? 'selected' : '' }}>Sold</option>
                        <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>

                <!-- From Date -->
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">From Date</label>
                    <input 
                        type="date" 
                        name="from_date" 
                        value="{{ request('from_date') }}" 
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-xs text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white font-mono"
                    >
                </div>

                <!-- To Date -->
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">To Date</label>
                    <input 
                        type="date" 
                        name="to_date" 
                        value="{{ request('to_date') }}" 
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-xs text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white font-mono"
                    >
                </div>

                <!-- Vendor -->
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Vendor</label>
                    <select name="vendor" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-xs text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white">
                        <option value="all">All Vendors</option>
                        @foreach($vendors as $v)
                            <option value="{{ $v->vendorid }}" {{ request('vendor') == $v->vendorid ? 'selected' : '' }}>
                                {{ $v->vendorname }} (#{{ $v->vendorid }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Vendor User ID -->
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Vendor User ID</label>
                    <input 
                        type="text" 
                        name="vendor_uid" 
                        value="{{ request('vendor_uid') }}" 
                        placeholder="Vendor User ID..." 
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:bg-white font-mono"
                    >
                </div>
            </div>

            <!-- Filter Buttons Row -->
            <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                <div class="flex items-center gap-2">
                    <label class="text-xs text-slate-500 font-medium">Per Page:</label>
                    <select name="per_page" onchange="this.form.submit()" class="px-2.5 py-1 bg-slate-50 border border-slate-300 rounded-lg text-xs text-slate-700">
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('dids.index') }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold flex items-center gap-1.5 transition-all">
                        <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                        <span>Reset</span>
                    </a>
                    <button type="submit" class="px-6 py-2 rounded-xl bg-[#0d244f] hover:bg-[#132c5b] text-white text-xs font-bold flex items-center gap-1.5 transition-all shadow-sm">
                        <i data-lucide="check" class="w-3.5 h-3.5"></i>
                        <span>Apply Filters</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Quick Action Bar -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <a href="{{ route('dids.allocate') }}" class="py-3 px-6 rounded-xl bg-[#0d244f] hover:bg-[#132c5b] text-white font-bold text-xs flex items-center justify-center gap-2 transition-all shadow-xs">
            <i data-lucide="plus-circle" class="w-4 h-4"></i>
            <span>+ Allocate DID</span>
        </a>
        <a href="{{ route('dids.create') }}" class="py-3 px-6 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs flex items-center justify-center gap-2 transition-all shadow-xs">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>+ Add New DID</span>
        </a>
    </div>

    <!-- DIDs List Table (Matching Screenshot 1) -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="p-4 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i data-lucide="layout-list" class="w-4 h-4 text-slate-700"></i>
                <h2 class="text-sm font-bold text-slate-800">DIDs List</h2>
                <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-xs font-mono font-bold">{{ number_format($dids->total()) }} Numbers</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs font-sans">
                <thead>
                    <tr class="bg-slate-50/75 text-slate-600 border-b border-slate-200 uppercase tracking-wider text-[10px] font-semibold">
                        <th class="py-3.5 px-3">NO.</th>
                        <th class="py-3.5 px-3 font-bold">DID NUMBER</th>
                        <th class="py-3.5 px-3">COUNTRY</th>
                        <th class="py-3.5 px-3">CITY</th>
                        <th class="py-3.5 px-3">STATE</th>
                        <th class="py-3.5 px-3 text-center">STATUS</th>
                        <th class="py-3.5 px-3">VENDOR</th>
                        <th class="py-3.5 px-3">VENDOR ORDER ID</th>
                        <th class="py-3.5 px-3">BUYER</th>
                        <th class="py-3.5 px-3">SETUP COST</th>
                        <th class="py-3.5 px-3">MONTHLY CHARGES</th>
                        <th class="py-3.5 px-3">PM</th>
                        <th class="py-3.5 px-3">CHANNELS</th>
                        <th class="py-3.5 px-3">FREE MIN</th>
                        <th class="py-3.5 px-3">OFFER DATE</th>
                        <th class="py-3.5 px-3 text-right">ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-[11px]">
                    @forelse($dids as $index => $did)
                        @php
                            $isAvailable = ($did->Status == 0 && !$did->SuspendDID);
                            $isSold = ($did->Status == 1 || $did->Status == 2 || $did->OID > 0);
                            $isSuspended = ($did->SuspendDID == 1 || $did->Status == 3);
                            
                            $statusLabel = $isSuspended ? 'SUSPENDED' : ($isSold ? 'SOLD' : 'AVAILABLE');
                            $statusBg = $isSuspended ? 'bg-amber-100 text-amber-800' : ($isSold ? 'bg-blue-100 text-blue-800' : 'bg-[#0d244f] text-white');
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <!-- NO -->
                            <td class="py-3 px-3 text-slate-400 font-mono">{{ $dids->firstItem() + $index }}</td>

                            <!-- DID NUMBER -->
                            <td class="py-3 px-3 font-bold font-mono text-slate-900">
                                <a href="{{ route('dids.show', $did->Id) }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                    +{{ $did->DIDNumber }}
                                </a>
                            </td>

                            <!-- COUNTRY -->
                            <td class="py-3 px-3 text-slate-700 font-medium">{{ $did->CountryN ?: ($did->country->CountryName ?? 'N/A') }}</td>

                            <!-- CITY -->
                            <td class="py-3 px-3 text-slate-600">{{ $did->City ?: 'Toll Free' }}</td>

                            <!-- STATE -->
                            <td class="py-3 px-3 text-slate-400">{{ $did->StateName ?: 'N/A' }}</td>

                            <!-- STATUS -->
                            <td class="py-3 px-3 text-center">
                                <span class="px-2.5 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider {{ $statusBg }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>

                            <!-- VENDOR -->
                            <td class="py-3 px-3">
                                <span class="text-slate-700 font-semibold block">{{ $did->GroupVendor > 0 ? ('Vendor #' . $did->GroupVendor) : 'N/A' }}</span>
                                <a href="{{ route('dids.index', ['vendor' => $did->GroupVendor]) }}" class="text-[10px] text-purple-600 hover:underline inline-flex items-center gap-0.5">
                                    <span>Vendor Inventory</span>
                                </a>
                            </td>

                            <!-- VENDOR ORDER ID -->
                            <td class="py-3 px-3 text-slate-600 font-mono">{{ $did->BOID ?: ($did->Id) }}</td>

                            <!-- BUYER -->
                            <td class="py-3 px-3">
                                @if($did->OID && $did->OID > 0)
                                    <a href="{{ route('customers.show', $did->OID) }}" class="text-blue-600 font-bold font-mono hover:underline">
                                        #{{ $did->OID }}
                                    </a>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>

                            <!-- SETUP COST -->
                            <td class="py-3 px-3 text-slate-700 font-mono">${{ number_format($did->SetupCost, 2) }}</td>

                            <!-- MONTHLY CHARGES -->
                            <td class="py-3 px-3 text-slate-700 font-bold font-mono">${{ number_format($did->MonthlyCharges, 2) }}</td>

                            <!-- PM -->
                            <td class="py-3 px-3 text-slate-600 font-mono">${{ number_format($did->PerMinuteCharges, 3) }}</td>

                            <!-- CHANNELS -->
                            <td class="py-3 px-3 text-slate-700 font-mono">{{ $did->iChannel ?: 100 }}</td>

                            <!-- FREE MIN -->
                            <td class="py-3 px-3 text-slate-500 font-mono">{{ $did->FreeMin ?: 0 }}</td>

                            <!-- OFFER DATE -->
                            <td class="py-3 px-3 text-slate-500 text-[10px] font-mono">{{ $did->OfferDate ? date('d/m/Y', strtotime($did->OfferDate)) : 'N/A' }}</td>

                            <!-- ACTIONS (Buttons row matching Screenshot 1) -->
                            <td class="py-3 px-3 text-right">
                                <div class="inline-flex items-center gap-1">
                                    <!-- View Details -->
                                    <a href="{{ route('dids.show', $did->Id) }}" title="View Details" class="p-1 rounded-md bg-[#0d244f] text-white hover:bg-[#132c5b] transition-colors">
                                        <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                    </a>

                                    <!-- Allocate -->
                                    <a href="{{ route('dids.allocate', ['did' => $did->DIDNumber]) }}" title="Allocate DID" class="p-1 rounded-md bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                                        <i data-lucide="user-plus" class="w-3.5 h-3.5"></i>
                                    </a>

                                    <!-- Message / Mail -->
                                    <a href="mailto:?subject=DID%20Number%20+{{ $did->DIDNumber }}" title="Email Details" class="p-1 rounded-md bg-purple-600 text-white hover:bg-purple-700 transition-colors">
                                        <i data-lucide="mail" class="w-3.5 h-3.5"></i>
                                    </a>

                                    <!-- Routing / AlterRingTo -->
                                    <a href="{{ route('dids.show', $did->Id) }}#routing" title="Configure Routing" class="p-1 rounded-md bg-emerald-600 text-white hover:bg-emerald-700 transition-colors">
                                        <i data-lucide="arrow-right-left" class="w-3.5 h-3.5"></i>
                                    </a>

                                    <!-- Suspend / Unsuspend -->
                                    <form action="{{ route('dids.toggle-suspend', $did->Id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" title="{{ $did->SuspendDID ? 'Unsuspend' : 'Suspend' }}" class="p-1 rounded-md {{ $did->SuspendDID ? 'bg-emerald-600' : 'bg-amber-500' }} text-white hover:opacity-90 transition-opacity">
                                            <i data-lucide="{{ $did->SuspendDID ? 'play' : 'pause' }}" class="w-3.5 h-3.5"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="16" class="py-12 text-center text-slate-400 font-sans text-xs">
                                No DIDs matching the selected search criteria found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100 bg-slate-50/50">
            {{ $dids->links() }}
        </div>
    </div>
</div>
@endsection
