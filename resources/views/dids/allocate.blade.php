@extends('layouts.app')

@section('title', 'DID Allocation')

@section('content')
<div class="space-y-6" x-data="didAllocationApp()">
    <!-- Breadcrumb (Matching Screenshot 2) -->
    <div class="flex items-center gap-2 text-xs text-slate-500 font-medium">
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline flex items-center gap-1">
            <i data-lucide="home" class="w-3.5 h-3.5"></i>
            <span>Dashboard</span>
        </a>
        <span>&gt;</span>
        <span class="text-slate-600">DID Allocation</span>
        <span>&gt;</span>
        <span class="text-slate-800 font-semibold">Allocate DID</span>
    </div>

    <!-- Header Banner (Matching Screenshot 2) -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <i data-lucide="user-plus" class="w-5 h-5"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">DID Allocation</h1>
                <p class="text-sm font-semibold text-slate-700 mt-0.5">Allocate DIDs to Customers</p>
                <p class="text-xs text-slate-400 mt-0.5">Manually assign available DIDs to customers with automatic transaction and billing setup</p>
            </div>
        </div>
    </div>

    <!-- Allocation Details Card (Matching Screenshot 2) -->
    <div class="max-w-4xl mx-auto bg-white rounded-2xl p-8 border border-slate-200/90 shadow-xs">
        <div class="flex items-center gap-2.5 pb-5 mb-6 border-b border-slate-100">
            <i data-lucide="phone" class="w-5 h-5 text-slate-700"></i>
            <h2 class="text-base font-bold text-slate-800">Allocation Details</h2>
        </div>

        <form action="{{ route('dids.allocate.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Search DID Number or ID -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                    Search DID Number or ID <span class="text-rose-500">*</span>
                </label>
                <div class="flex gap-2">
                    <input 
                        type="text" 
                        name="DIDNumber" 
                        x-model="didNumber"
                        required 
                        placeholder="Enter DID Number or ID" 
                        class="flex-1 px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white font-mono"
                    >
                    <button 
                        type="button" 
                        @click="searchDidModal = true"
                        class="px-6 py-2.5 bg-slate-600 hover:bg-slate-700 text-white font-semibold text-xs rounded-xl flex items-center gap-1.5 transition-all shadow-sm"
                    >
                        <i data-lucide="search" class="w-3.5 h-3.5"></i>
                        <span>Search</span>
                    </button>
                </div>
            </div>

            <!-- Buyer Order ID (OID) & Vendor User ID Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Buyer Order ID -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Buyer Order ID (OID) <span class="text-rose-500">*</span>
                    </label>
                    <div class="flex gap-2">
                        <input 
                            type="text" 
                            name="OID" 
                            x-model="buyerOid"
                            required 
                            placeholder="Enter Buyer OID" 
                            class="flex-1 px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white font-mono"
                        >
                        <button 
                            type="button" 
                            @click="browseBuyersModal = true"
                            class="px-4 py-2.5 bg-slate-600 hover:bg-slate-700 text-white font-semibold text-xs rounded-xl flex items-center gap-1.5 transition-all shadow-sm whitespace-nowrap"
                        >
                            <i data-lucide="users" class="w-3.5 h-3.5"></i>
                            <span>Browse Buyers</span>
                        </button>
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1 italic">
                        Enter Buyer Order OID or click "Browse Buyers" to select from list
                    </p>
                </div>

                <!-- Vendor User ID -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Vendor User ID
                    </label>
                    <input 
                        type="text" 
                        name="VendorUID" 
                        x-model="vendorUid"
                        placeholder="Enter Vendor User ID (e.g., 118)" 
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white font-mono"
                    >
                </div>
            </div>

            <!-- Ring To URL -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                    Ring To URL
                </label>
                <input 
                    type="text" 
                    name="RingTo" 
                    value="echo@us1.didx.net" 
                    placeholder="e.g. echo@us1.didx.net or SIP/carrier/12345" 
                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white font-mono"
                >
                <p class="text-[11px] text-slate-400 mt-1 italic">
                    Use echo to verify the DID is working (echo@us1.didx.net)
                </p>
            </div>

            <!-- Channel-Based Allocation Checkbox -->
            <div class="flex items-center gap-2 pt-1">
                <input 
                    type="checkbox" 
                    name="channel_based" 
                    id="channel_based" 
                    class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500 border-slate-300"
                >
                <label for="channel_based" class="text-xs font-semibold text-slate-700 cursor-pointer">
                    Channel-Based Allocation
                </label>
            </div>

            <!-- Form Action Buttons (Matching Screenshot 2) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-slate-100">
                <button 
                    type="submit" 
                    class="w-full py-3 px-6 rounded-xl bg-[#0d244f] hover:bg-[#132c5b] text-white font-bold text-xs flex items-center justify-center gap-2 transition-all shadow-sm active:scale-95"
                >
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>Allocate DID</span>
                </button>

                <button 
                    type="reset" 
                    @click="resetForm()"
                    class="w-full py-3 px-6 rounded-xl bg-slate-600 hover:bg-slate-700 text-white font-semibold text-xs flex items-center justify-center gap-2 transition-all shadow-sm active:scale-95"
                >
                    <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                    <span>Reset</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Browse Buyers Modal -->
    <div 
        x-show="browseBuyersModal" 
        class="fixed inset-0 z-50 bg-black/50 backdrop-blur-xs flex items-center justify-center p-4"
        x-cloak
    >
        <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[85vh] flex flex-col shadow-2xl border border-slate-200">
            <div class="p-4 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i data-lucide="users" class="w-5 h-5 text-blue-600"></i>
                    <h3 class="text-sm font-bold text-slate-800">Select Customer / Buyer OID</h3>
                </div>
                <button @click="browseBuyersModal = false" class="text-slate-400 hover:text-slate-700">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <!-- Search Input in Modal -->
            <div class="p-4 border-b border-slate-100 bg-slate-50">
                <div class="relative">
                    <i data-lucide="search" class="w-3.5 h-3.5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                    <input 
                        type="text" 
                        x-model="buyerSearch" 
                        @input.debounce.300ms="fetchBuyers()" 
                        placeholder="Search buyer by OID, Name, Company, or Email..." 
                        class="w-full pl-9 pr-4 py-2 bg-white border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:border-blue-500 font-sans"
                    >
                </div>
            </div>

            <!-- Buyers List -->
            <div class="overflow-y-auto flex-1 p-4 divide-y divide-slate-100 text-xs">
                <template x-for="b in buyersList" :key="b.CustomerID">
                    <div 
                        @click="selectBuyer(b.CustomerID)"
                        class="p-3 hover:bg-blue-50/70 rounded-xl cursor-pointer flex items-center justify-between transition-colors"
                    >
                        <div>
                            <span class="font-bold text-blue-600 font-mono" x-text="'#' + b.CustomerID"></span>
                            <span class="text-slate-800 font-medium ml-2" x-text="b.CFName + ' ' + (b.CLName || '')"></span>
                            <p class="text-[11px] text-slate-500" x-text="(b.CCompany || 'Personal Account') + ' • ' + (b.CEmail || 'No email')"></p>
                        </div>
                        <button class="px-3 py-1 bg-blue-600 text-white rounded-lg text-[11px] font-semibold">Select</button>
                    </div>
                </template>
                <div x-show="buyersList.length === 0" class="py-8 text-center text-slate-400">
                    Type a search term above to find registered buyers.
                </div>
            </div>
        </div>
    </div>

    <!-- Search DID Modal -->
    <div 
        x-show="searchDidModal" 
        class="fixed inset-0 z-50 bg-black/50 backdrop-blur-xs flex items-center justify-center p-4"
        x-cloak
    >
        <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[85vh] flex flex-col shadow-2xl border border-slate-200">
            <div class="p-4 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i data-lucide="phone" class="w-5 h-5 text-blue-600"></i>
                    <h3 class="text-sm font-bold text-slate-800">Search Available DIDs</h3>
                </div>
                <button @click="searchDidModal = false" class="text-slate-400 hover:text-slate-700">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <!-- Search Input in Modal -->
            <div class="p-4 border-b border-slate-100 bg-slate-50">
                <div class="relative">
                    <i data-lucide="search" class="w-3.5 h-3.5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                    <input 
                        type="text" 
                        x-model="didSearchTerm" 
                        @input.debounce.300ms="fetchDids()" 
                        placeholder="Search DID by Number, Country, City..." 
                        class="w-full pl-9 pr-4 py-2 bg-white border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:border-blue-500 font-mono"
                    >
                </div>
            </div>

            <!-- DIDs List -->
            <div class="overflow-y-auto flex-1 p-4 divide-y divide-slate-100 text-xs">
                <template x-for="d in didsList" :key="d.Id">
                    <div 
                        @click="selectDid(d)"
                        class="p-3 hover:bg-blue-50/70 rounded-xl cursor-pointer flex items-center justify-between transition-colors"
                    >
                        <div>
                            <span class="font-bold text-blue-600 font-mono" x-text="'+' + d.DIDNumber"></span>
                            <span class="text-slate-800 font-medium ml-2" x-text="(d.CountryN || 'International') + ' (' + (d.City || 'Toll Free') + ')'"></span>
                            <p class="text-[11px] text-slate-500 font-mono" x-text="'MRC: $' + d.MonthlyCharges + ' • Vendor: #' + d.GroupVendor"></p>
                        </div>
                        <button class="px-3 py-1 bg-[#0d244f] text-white rounded-lg text-[11px] font-semibold">Select DID</button>
                    </div>
                </template>
                <div x-show="didsList.length === 0" class="py-8 text-center text-slate-400">
                    Search for a DID number to select.
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function didAllocationApp() {
    return {
        didNumber: '{{ $didNumber ?: "" }}',
        buyerOid: '',
        vendorUid: '{{ $selectedDid->GroupVendor ?? "" }}',
        browseBuyersModal: false,
        searchDidModal: false,
        buyerSearch: '',
        didSearchTerm: '',
        buyersList: [],
        didsList: [],
        init() {
            this.fetchBuyers();
            this.fetchDids();
        },
        fetchBuyers() {
            fetch(`/api/buyers/search?q=${encodeURIComponent(this.buyerSearch)}`)
                .then(res => res.json())
                .then(data => { this.buyersList = data; });
        },
        fetchDids() {
            fetch(`/api/dids/search?q=${encodeURIComponent(this.didSearchTerm)}`)
                .then(res => res.json())
                .then(data => { this.didsList = data; });
        },
        selectBuyer(oid) {
            this.buyerOid = oid;
            this.browseBuyersModal = false;
        },
        selectDid(did) {
            this.didNumber = did.DIDNumber;
            this.vendorUid = did.GroupVendor || '';
            this.searchDidModal = false;
        },
        resetForm() {
            this.didNumber = '';
            this.buyerOid = '';
            this.vendorUid = '';
        }
    }
}
</script>
@endsection
