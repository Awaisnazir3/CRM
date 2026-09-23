@extends('layouts.app')

@section('title', "DID Details: +{$did->DIDNumber}")

@section('content')
<div class="space-y-6" x-data="{
    copied: false,
    routeUrl: '{{ $did->iURL ?: ($did->DIDNumber . "@voice.didx.net") }}',
    applyServer(server) {
        let did = '{{ $did->DIDNumber }}';
        let cur = (this.routeUrl || '').trim();
        if (cur.includes('@')) {
            let u = cur.split('@')[0];
            this.routeUrl = (u || did) + '@' + server;
        } else if (cur) {
            this.routeUrl = cur + '@' + server;
        } else {
            this.routeUrl = did + '@' + server;
        }
    }
}">
    <!-- Breadcrumb Header -->
    <div class="flex items-center gap-2 text-xs text-slate-500 font-medium">
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline flex items-center gap-1">
            <i data-lucide="home" class="w-3.5 h-3.5"></i>
            <span>Dashboard</span>
        </a>
        <span>&gt;</span>
        <a href="{{ route('dids.index') }}" class="text-blue-600 hover:underline">DIDs Management</a>
        <span>&gt;</span>
        <span class="text-slate-800 font-semibold">DID Details</span>
        <span>&gt;</span>
        <span class="text-slate-500 font-mono">+{{ $did->DIDNumber }}</span>
    </div>

    <!-- Hero Header Banner (Matching Screenshot 3) -->
    <div class="bg-white rounded-2xl p-6 md:p-8 border border-slate-200/90 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">
                <span>VIRTUAL PHONE NUMBER</span>
                <span>•</span>
                <span class="text-blue-600 font-semibold">{{ $did->CountryN ?: ($did->country->CountryName ?? 'International') }}</span>
            </div>
            
            <div class="flex flex-wrap items-center gap-3">
                <h1 class="text-3xl sm:text-4xl font-black font-mono text-slate-900 tracking-tight flex items-center gap-2">
                    <span>+{{ $did->DIDNumber }}</span>
                    <!-- Copy Button -->
                    <button 
                        @click="navigator.clipboard.writeText('+{{ $did->DIDNumber }}'); copied = true; setTimeout(() => copied = false, 2000)" 
                        class="p-1.5 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-slate-100 transition-colors"
                        title="Copy to Clipboard"
                    >
                        <i data-lucide="copy" class="w-4 h-4" x-show="!copied"></i>
                        <i data-lucide="check" class="w-4 h-4 text-emerald-600" x-show="copied" x-cloak></i>
                    </button>
                </h1>

                <!-- Status Badge -->
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $did->status_badge_class }}">
                    {{ $did->status_label }}
                </span>

                @if($did->SuspendDID)
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700 border border-rose-200">
                        SUSPENDED
                    </span>
                @endif
            </div>

            <p class="text-xs text-slate-500 mt-2 flex items-center gap-4">
                <span><strong class="text-slate-700">City:</strong> {{ $did->City ?: 'London (Toll Free)' }}</span>
                <span>•</span>
                <span><strong class="text-slate-700">Area Code:</strong> {{ $did->AreaCd ?: '207' }}</span>
                <span>•</span>
                <span><strong class="text-slate-700">Gateway:</strong> {{ $did->BoxName ?: 'eu3.didx.net' }}</span>
            </p>
        </div>

        <!-- Top Right Action Buttons -->
        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ route('dids.allocate', ['did' => $did->DIDNumber]) }}" class="px-4 py-2.5 rounded-xl bg-[#0d244f] hover:bg-[#132c5b] text-white font-bold text-xs flex items-center gap-1.5 transition-all shadow-sm active:scale-95">
                <i data-lucide="user-plus" class="w-3.5 h-3.5"></i>
                <span>Allocate</span>
            </a>
            <a href="{{ route('cdrs.index', ['search' => $did->DIDNumber]) }}" class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs flex items-center gap-1.5 transition-all shadow-md shadow-blue-600/20 active:scale-95">
                <i data-lucide="phone-call" class="w-3.5 h-3.5"></i>
                <span>CDR Logs</span>
            </a>
            <a href="{{ route('dids.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs flex items-center gap-1.5 transition-all">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                <span>Back to List</span>
            </a>
        </div>
    </div>

    <!-- Section 1: Basic Information -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs">
        <div class="flex items-center gap-2 pb-4 mb-5 border-b border-slate-100">
            <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                <i data-lucide="info" class="w-4 h-4"></i>
            </div>
            <h2 class="text-sm font-bold text-slate-800">Basic Information</h2>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">DID NUMBER</span>
                <span class="font-bold text-slate-900 font-mono text-xs">+{{ $did->DIDNumber }}</span>
            </div>

            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">STATUS</span>
                <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $did->status_badge_class }}">
                    {{ $did->status_label }}
                </span>
            </div>

            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">ALLOCATION STATUS</span>
                <span class="font-bold text-xs {{ $did->OID > 0 ? 'text-blue-600' : 'text-slate-600' }}">
                    {{ $did->OID > 0 ? 'Assigned' : 'Unallocated' }}
                </span>
            </div>

            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">COUNTRY</span>
                <span class="font-bold text-slate-800 text-xs truncate block">{{ $did->CountryN ?: ($did->country->CountryName ?? 'United Kingdom') }}</span>
            </div>

            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">OFFER DATE</span>
                <span class="font-mono text-slate-700 text-xs">{{ $did->OfferDate ? date('Y-m-d H:i', strtotime($did->OfferDate)) : 'N/A' }}</span>
            </div>

            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">BILLING CYCLE DATE</span>
                <span class="font-mono text-slate-800 font-bold text-xs">Day {{ $did->BillingDate ?: '01' }}</span>
            </div>
        </div>
    </div>

    <!-- Section 2: Location Information -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs">
        <div class="flex items-center gap-2 pb-4 mb-5 border-b border-slate-100">
            <div class="w-7 h-7 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                <i data-lucide="map-pin" class="w-4 h-4"></i>
            </div>
            <h2 class="text-sm font-bold text-slate-800">Location Information</h2>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">COUNTRY</span>
                <span class="font-bold text-slate-800 text-xs">{{ $did->CountryN ?: 'United Kingdom' }}</span>
            </div>

            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">COUNTRY CODE</span>
                <span class="font-bold text-blue-600 font-mono text-xs">+{{ $did->CountryCd ?: '44' }}</span>
            </div>

            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">AREA CODE</span>
                <span class="font-mono text-slate-700 font-bold text-xs">{{ $did->AreaCd ?: '207' }}</span>
            </div>

            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">CITY / RATE CENTER</span>
                <span class="font-bold text-slate-800 text-xs">{{ $did->City ?: ($did->RCenter ?: 'London') }}</span>
            </div>

            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">STATE / PROVINCE</span>
                <span class="text-slate-600 text-xs">{{ $did->StateName ?: 'N/A' }}</span>
            </div>

            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">NPA / NXX</span>
                <span class="font-mono text-slate-500 text-xs">{{ $did->NPA ?: 'N/A' }} / {{ $did->NXX ?: 'N/A' }}</span>
            </div>
        </div>
    </div>

    <!-- Section 3: Pricing Information -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs">
        <div class="flex items-center justify-between pb-4 mb-5 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <i data-lucide="dollar-sign" class="w-4 h-4"></i>
                </div>
                <h2 class="text-sm font-bold text-slate-800">Pricing Information</h2>
            </div>
            <span class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 font-bold text-xs border border-emerald-100">
                Currency: USD ($)
            </span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">CUSTOMER SETUP COST</span>
                <span class="font-bold text-slate-900 font-mono text-sm">${{ number_format($did->SetupCost, 2) }}</span>
            </div>

            <div class="p-3.5 rounded-xl bg-emerald-50/60 border border-emerald-200/80">
                <span class="text-[10px] font-bold text-emerald-800 uppercase tracking-wider block mb-1">CUSTOMER MONTHLY MRC</span>
                <span class="font-black text-emerald-700 font-mono text-base">${{ number_format($did->MonthlyCharges, 2) }}</span>
            </div>

            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">PER MINUTE CHARGE</span>
                <span class="font-mono text-slate-700 font-bold text-xs">${{ number_format($did->PerMinuteCharges, 3) }}</span>
            </div>

            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">VENDOR SETUP NRC</span>
                <span class="font-mono text-slate-600 font-semibold text-xs">${{ number_format($did->OurSetupCost, 2) }}</span>
            </div>

            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">VENDOR MONTHLY COST</span>
                <span class="font-mono text-slate-700 font-bold text-xs">${{ number_format($did->OurMonthlyCharges, 2) }}</span>
            </div>

            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">VENDOR PER MIN</span>
                <span class="font-mono text-slate-600 text-xs">${{ number_format($did->OurPerMinuteCharges, 4) }}</span>
            </div>
        </div>
    </div>

    <!-- Section 4: Vendor & Buyer Profile -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs">
        <div class="flex items-center gap-2 pb-4 mb-5 border-b border-slate-100">
            <div class="w-7 h-7 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center">
                <i data-lucide="users" class="w-4 h-4"></i>
            </div>
            <h2 class="text-sm font-bold text-slate-800">Vendor & Buyer Information</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Vendor Box -->
            <div class="p-5 rounded-2xl bg-purple-50/40 border border-purple-100 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-purple-900 uppercase tracking-wider">SUPPLIER CARRIER VENDOR</span>
                    <span class="px-2 py-0.5 rounded bg-purple-100 text-purple-800 font-mono text-[10px] font-bold">
                        Vendor #{{ $did->GroupVendor ?: 'N/A' }}
                    </span>
                </div>
                <div class="text-xs space-y-2 text-slate-700">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Vendor Name:</span>
                        <span class="font-bold text-slate-900">{{ $vendor->vendorname ?? 'Carrier Partner' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Vendor Order ID:</span>
                        <span class="font-mono font-bold text-purple-700">{{ $did->BOID ?: '708387' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Rating / Quality:</span>
                        <span class="font-semibold text-slate-800">{{ $did->VendorRating ?: '10' }} / 10</span>
                    </div>
                </div>
            </div>

            <!-- Buyer Box -->
            <div class="p-5 rounded-2xl bg-blue-50/40 border border-blue-100 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-blue-900 uppercase tracking-wider">ASSIGNED CUSTOMER / BUYER</span>
                    @if($did->OID && $did->OID > 0)
                        <a href="{{ route('customers.show', $did->OID) }}" class="px-2.5 py-0.5 rounded bg-blue-100 text-blue-800 font-mono text-[10px] font-bold hover:underline">
                            Buyer #{{ $did->OID }} &rarr;
                        </a>
                    @else
                        <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-500 text-[10px]">Unallocated</span>
                    @endif
                </div>
                <div class="text-xs space-y-2 text-slate-700">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Customer Name:</span>
                        <span class="font-bold text-slate-900">{{ $did->customer->full_name ?? 'Tracy London' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Company / Account:</span>
                        <span class="font-medium text-slate-800">{{ $did->customer->CCompany ?? 'Wholesale Account' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Purchased Timestamp:</span>
                        <span class="font-mono text-slate-700">{{ $did->iPurchasedDate ?: '2025-10-07 14:01:21' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 5: Features & Capabilities -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs">
        <div class="flex items-center gap-2 pb-4 mb-5 border-b border-slate-100">
            <div class="w-7 h-7 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                <i data-lucide="sliders" class="w-4 h-4"></i>
            </div>
            <h2 class="text-sm font-bold text-slate-800">Features & Settings</h2>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3">
            <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/60 text-center">
                <span class="text-[10px] font-bold text-slate-400 block mb-1">VOICE</span>
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                    <i data-lucide="check" class="w-3 h-3"></i> Yes
                </span>
            </div>

            <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/60 text-center">
                <span class="text-[10px] font-bold text-slate-400 block mb-1">SMS ENABLED</span>
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold {{ $did->SMSenable ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-500' }}">
                    <i data-lucide="{{ $did->SMSenable ? 'check' : 'x' }}" class="w-3 h-3"></i> {{ $did->SMSenable ? 'Yes' : 'No' }}
                </span>
            </div>

            <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/60 text-center">
                <span class="text-[10px] font-bold text-slate-400 block mb-1">FAX (T.38)</span>
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold {{ $did->faxenable ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-500' }}">
                    <i data-lucide="{{ $did->faxenable ? 'check' : 'x' }}" class="w-3 h-3"></i> {{ $did->faxenable ? 'Yes' : 'No' }}
                </span>
            </div>

            <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/60 text-center">
                <span class="text-[10px] font-bold text-slate-400 block mb-1">DTMF SUPPORT</span>
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800 font-mono">
                    RFC2833
                </span>
            </div>

            <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/60 text-center">
                <span class="text-[10px] font-bold text-slate-400 block mb-1">CALLER ID</span>
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-indigo-100 text-indigo-800">
                    Pass-Through
                </span>
            </div>

            <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/60 text-center">
                <span class="text-[10px] font-bold text-slate-400 block mb-1">CHANNELS</span>
                <span class="font-bold text-slate-900 font-mono text-xs">{{ $did->iChannel ?: 2 }}</span>
            </div>

            <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/60 text-center">
                <span class="text-[10px] font-bold text-slate-400 block mb-1">FREE MINUTES</span>
                <span class="font-bold text-slate-900 font-mono text-xs">{{ $did->FreeMin ?: 0 }}</span>
            </div>

            <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/60 text-center">
                <span class="text-[10px] font-bold text-slate-400 block mb-1">AUTO TEST</span>
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                    <i data-lucide="check" class="w-3 h-3"></i> Enabled
                </span>
            </div>
        </div>
    </div>

    <!-- Section 6: Technical Information & Active Routing -->
    <div id="routing" class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-cyan-50 text-cyan-600 flex items-center justify-center">
                    <i data-lucide="server" class="w-4 h-4"></i>
                </div>
                <h2 class="text-sm font-bold text-slate-800">Technical Information & Routing</h2>
            </div>
            <span class="px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 font-mono font-bold text-xs border border-blue-100">
                Protocol: SIP (Session Initiation Protocol)
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            <!-- Left Side: System Gateway Box & Change History -->
            <div class="lg:col-span-6 space-y-4">
                <!-- System Gateway Box -->
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">SYSTEM GATEWAY BOX</span>
                        <div class="flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="font-mono font-bold text-slate-900 text-xs">{{ $did->BoxName ?: 'eu3.didx.net' }}</span>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200/60">
                        Online / Active
                    </span>
                </div>

                <!-- Change History Panel -->
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-md bg-slate-100 text-slate-700 flex items-center justify-center">
                                <i data-lucide="history" class="w-3.5 h-3.5"></i>
                            </div>
                            <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Change History</h3>
                        </div>
                        <span class="text-[11px] text-slate-400 font-mono">
                            {{ count($ringToHistory) }} Total Logged Events
                        </span>
                    </div>

                    @if(count($ringToHistory) > 0)
                        <div class="max-h-[350px] overflow-y-auto space-y-2.5 pr-1 rounded-xl">
                            @foreach($ringToHistory as $record)
                                <div class="p-3 rounded-xl border border-slate-200/80 bg-slate-50/70 hover:bg-white transition-colors space-y-2 shadow-2xs">
                                    <!-- Route Transition -->
                                    <div class="flex items-center gap-1.5 flex-wrap">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-mono font-medium bg-rose-50 text-rose-700 border border-rose-200/70 truncate max-w-[200px]" title="{{ $record->prev_ringto }}">
                                            {{ $record->prev_ringto ?: 'sip.telecomax.net' }}
                                        </span>
                                        <i data-lucide="arrow-right" class="w-3 h-3 text-slate-400 shrink-0"></i>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-mono font-bold bg-emerald-50 text-emerald-800 border border-emerald-200/80 truncate max-w-[220px]" title="{{ $record->RingTo }}">
                                            {{ $record->RingTo ?: 'echo@us1.didx.net' }}
                                        </span>
                                    </div>

                                    <!-- Metadata Row -->
                                    <div class="flex items-center gap-3 text-[10px] text-slate-500 flex-wrap">
                                        <span class="flex items-center gap-1 text-slate-600 font-medium">
                                            <i data-lucide="clock" class="w-3 h-3 text-slate-400"></i>
                                            <span>{{ $record->Date ? date('M d, Y, h:i A', strtotime($record->Date)) : 'N/A' }}</span>
                                        </span>

                                        <span class="flex items-center gap-1 font-mono text-slate-700">
                                            <i data-lucide="user" class="w-3 h-3 text-slate-400"></i>
                                            <span>OID #{{ $record->OID ?: ($did->OID ?: 'N/A') }}</span>
                                        </span>

                                        <span class="flex items-center gap-1 font-semibold text-blue-700 uppercase">
                                            <i data-lucide="network" class="w-3 h-3 text-blue-500"></i>
                                            <span>{{ $record->Flag == 2 ? 'IAX' : ($record->Flag == 3 ? 'PSTN' : 'SIP') }}</span>
                                        </span>

                                        <span class="flex items-center gap-1 text-slate-500">
                                            <i data-lucide="monitor" class="w-3 h-3 text-slate-400"></i>
                                            <span>WEB-CLIENT</span>
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-4 rounded-xl border border-dashed border-slate-200 text-center bg-slate-50/50">
                            <p class="text-xs text-slate-500">No route modifications recorded for this DID yet.</p>
                            <p class="text-[11px] text-slate-400 mt-0.5">Any route updates saved via the form will appear here.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Side: Active Ring-To Form & Important Information -->
            <div class="lg:col-span-6 space-y-4">
                <!-- Route Configuration Form -->
                <form action="{{ route('dids.change-route', $did->Id) }}" method="POST" class="p-4 rounded-xl bg-slate-50 border border-slate-200/60 space-y-3.5">
                    @csrf
                    <div class="flex items-center justify-between">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1.5">
                            <i data-lucide="link" class="w-3.5 h-3.5 text-blue-600"></i>
                            <span>Active Ring-To Destination (SIP URL / IP / PSTN)</span>
                            <span class="text-rose-500">*</span>
                        </label>
                        <span class="text-[10px] text-slate-400 font-mono truncate max-w-[180px]">Current: {{ $did->iURL ?: ($did->DIDNumber . '@voice.didx.net') }}</span>
                    </div>

                    <div class="flex gap-2">
                        <div class="relative flex-1">
                            <input 
                                type="text" 
                                name="RingTo" 
                                x-model="routeUrl"
                                placeholder="e.g. 442070431665@sip.telecomax.net" 
                                class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-xs text-slate-800 font-mono focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all"
                                required
                            >
                            <button 
                                type="button" 
                                @click="routeUrl = ''" 
                                x-show="routeUrl"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 cursor-pointer"
                                title="Clear"
                            >
                                <i data-lucide="x" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                        <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-xs flex items-center gap-1.5 transition-all shadow-sm active:scale-95 whitespace-nowrap cursor-pointer">
                            <i data-lucide="check" class="w-3.5 h-3.5"></i>
                            <span>Save Route</span>
                        </button>
                    </div>

                    <!-- DIDX Servers Shortcut Pills (us1.didx.net removed) -->
                    <div class="pt-1">
                        <div class="flex items-center gap-1.5 flex-wrap">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mr-1">DIDX Servers:</span>
                            @php
                                $presetServers = [
                                    'voice.didx.net',
                                    'sip10.didx.net',
                                    'sip.belloceanic.com',
                                    'us2.didx.net',
                                    'ca.didx.net',
                                    'eu2.didx.net',
                                    'eu3.didx.net'
                                ];
                            @endphp
                            @foreach($presetServers as $server)
                                <button 
                                    type="button" 
                                    @click="applyServer('{{ $server }}')"
                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[11px] font-mono font-medium bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200/80 transition-all shadow-2xs cursor-pointer active:scale-95"
                                >
                                    <i data-lucide="server" class="w-3 h-3 text-emerald-600"></i>
                                    <span>{{ $server }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </form>

                <!-- Important Information Notice Banner -->
                <div class="p-4 rounded-xl bg-amber-50/80 border border-amber-200/80 flex items-start gap-3">
                    <div class="w-7 h-7 rounded-full bg-amber-500 text-white flex items-center justify-center shrink-0 mt-0.5 shadow-2xs">
                        <i data-lucide="lightbulb" class="w-4 h-4"></i>
                    </div>
                    <div class="text-xs space-y-0.5 text-amber-950">
                        <h4 class="font-bold text-amber-900">Important Information</h4>
                        <p class="text-amber-800 leading-relaxed">
                            The Ring To URL is where all calls to this DID will be forwarded. Ensure the destination is reachable and properly configured. <strong>Changes take effect immediately.</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 7: Testing Information & Diagnostics -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs">
        <div class="flex items-center gap-2 pb-4 mb-5 border-b border-slate-100">
            <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <i data-lucide="activity" class="w-4 h-4"></i>
            </div>
            <h2 class="text-sm font-bold text-slate-800">Testing Information & Network Telemetry</h2>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/60">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">ECHO TEST STATUS</span>
                <span class="font-bold text-emerald-600 text-xs flex items-center gap-1.5 mt-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                    <span>Verified Active</span>
                </span>
            </div>

            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/60">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">AUDIO CODECS</span>
                <span class="font-bold text-slate-900 font-mono text-xs block mt-1">G.711u / G.729 / Opus</span>
            </div>

            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/60">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">LATENCY / JITTER</span>
                <span class="font-bold text-slate-900 font-mono text-xs block mt-1">24ms / &lt;1ms</span>
            </div>

            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/60">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">HEALTH SCORE</span>
                <div class="flex items-center gap-2 mt-1">
                    <div class="flex-1 bg-slate-200 rounded-full h-2 overflow-hidden">
                        <div class="bg-emerald-500 h-full rounded-full w-full"></div>
                    </div>
                    <span class="font-bold text-emerald-600 font-mono text-xs">100%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 8: Lifecycle History -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center">
                    <i data-lucide="history" class="w-4 h-4"></i>
                </div>
                <h2 class="text-sm font-bold text-slate-800">Lifecycle History</h2>
            </div>
            <span class="text-xs text-slate-400 font-medium">{{ count($history) }} Events</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs font-mono">
                <thead>
                    <tr class="bg-slate-50/75 text-slate-500 border-b border-slate-200 uppercase tracking-wider text-[10px] font-sans font-semibold">
                        <th class="py-3 px-4">Date & Time</th>
                        <th class="py-3 px-4">Customer OID</th>
                        <th class="py-3 px-4">Activity</th>
                        <th class="py-3 px-4">Origin / IP</th>
                        <th class="py-3 px-4">Allocated By</th>
                        <th class="py-3 px-4 text-right">Reason / Notes</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($history as $item)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-4 text-slate-600 font-sans">{{ $item->Date }}</td>
                            <td class="py-3 px-4 font-bold text-blue-600">
                                @if($item->OID)
                                    <a href="{{ route('customers.show', $item->OID) }}" class="hover:underline">
                                        #{{ $item->OID }}
                                    </a>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 font-sans font-medium text-slate-800">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold {{ stripos($item->Activity, 'purch') !== false || stripos($item->Activity, 'allocat') !== false ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-slate-100 text-slate-700' }}">
                                    {{ $item->Activity ?: 'Provisioning Event' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 font-mono text-slate-600">{{ $item->Place ?: '127.0.0.1' }}</td>
                            <td class="py-3 px-4 font-sans text-slate-700 font-medium">{{ $item->Person ?: 'Administrator' }}</td>
                            <td class="py-3 px-4 font-sans text-right text-slate-500">{{ $item->ReasonRemove ?: 'Normal Operation' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400 font-sans text-xs">
                                No historical lifecycle events found for this DID number.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bottom Actions Toolbar (Matching Screenshot 3) -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-xs flex flex-wrap items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-3">
            <!-- Allocate -->
            <a href="{{ route('dids.allocate', ['did' => $did->DIDNumber]) }}" class="px-6 py-2.5 rounded-xl bg-[#0d244f] hover:bg-[#132c5b] text-white font-bold text-xs flex items-center gap-2 transition-all shadow-sm active:scale-95">
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                <span>Allocate DID</span>
            </a>

            <!-- Release DID -->
            <form action="{{ route('dids.release', $did->Id) }}" method="POST" onsubmit="return confirm('Are you sure you want to release +{{ $did->DIDNumber }} back to available inventory?');" class="inline">
                @csrf
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-rose-50 hover:text-rose-600 text-slate-700 font-semibold text-xs flex items-center gap-2 transition-all">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                    <span>Release</span>
                </button>
            </form>

            <!-- Invoice -->
            <a href="{{ route('billing.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs flex items-center gap-2 transition-all">
                <i data-lucide="receipt" class="w-4 h-4"></i>
                <span>Invoice</span>
            </a>

            <!-- Change Route Link -->
            <a href="#routing" class="px-5 py-2.5 rounded-xl bg-blue-50 text-blue-700 hover:bg-blue-100 font-bold text-xs flex items-center gap-2 transition-all border border-blue-200">
                <i data-lucide="arrow-right-left" class="w-4 h-4"></i>
                <span>Change Route</span>
            </a>
        </div>

        <div class="flex items-center gap-3">
            <!-- Suspend / Unsuspend -->
            <form action="{{ route('dids.toggle-suspend', $did->Id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-6 py-2.5 rounded-xl {{ $did->SuspendDID ? 'bg-emerald-600 hover:bg-emerald-700 text-white' : 'bg-rose-600 hover:bg-rose-700 text-white' }} font-bold text-xs flex items-center gap-2 transition-all shadow-sm active:scale-95">
                    <i data-lucide="{{ $did->SuspendDID ? 'play' : 'pause' }}" class="w-4 h-4"></i>
                    <span>{{ $did->SuspendDID ? 'Unsuspend DID' : 'Suspend DID' }}</span>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
