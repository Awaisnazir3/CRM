@extends('layouts.app')

@section('title', 'Add DID to Inventory')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center gap-2 text-xs text-slate-500 font-medium mb-1">
        <a href="{{ route('dids.index') }}" class="text-blue-600 hover:underline flex items-center gap-1">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            <span>Back to Inventory</span>
        </a>
    </div>

    <div class="bg-white p-8 rounded-2xl border border-slate-200/90 shadow-xs">
        <div class="mb-6 pb-6 border-b border-slate-100">
            <h1 class="text-xl font-bold text-slate-800 flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                </div>
                <span>Provision New DID Number</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1 ml-10.5">Register a new virtual phone number into the DIDX2 database repository</p>
        </div>

        <form action="{{ route('dids.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5 uppercase tracking-wider">DID Phone Number (E.164 without +)</label>
                    <input 
                        type="number" 
                        name="DIDNumber" 
                        required 
                        placeholder="e.g. 12025550199 or 442079460912" 
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white font-mono transition-all"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5 uppercase tracking-wider">Country & Area</label>
                    <select name="AreaID" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white transition-all">
                        @foreach($countries as $c)
                            <option value="{{ $c->CountryID }}">{{ $c->CountryName }} (+{{ $c->CountryCode }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5 uppercase tracking-wider">Carrier / Vendor</label>
                    <select name="GroupVendor" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white transition-all">
                        @foreach($vendors as $v)
                            <option value="{{ $v->vendorid }}">{{ $v->vendorname }} (#{{ $v->vendorid }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5 uppercase tracking-wider">Monthly Recurring Charge ($)</label>
                    <input 
                        type="number" 
                        step="0.01" 
                        name="MonthlyCharges" 
                        value="1.00" 
                        required 
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white font-mono transition-all"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5 uppercase tracking-wider">Setup NRC ($)</label>
                    <input 
                        type="number" 
                        step="0.01" 
                        name="SetupCost" 
                        value="0.00" 
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white font-mono transition-all"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5 uppercase tracking-wider">Per Minute Cost ($)</label>
                    <input 
                        type="number" 
                        step="0.0001" 
                        name="PerMinuteCharges" 
                        value="0.0000" 
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white font-mono transition-all"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5 uppercase tracking-wider">Concurrent Channels</label>
                    <input 
                        type="number" 
                        name="channels" 
                        value="2" 
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white font-mono transition-all"
                    >
                </div>
            </div>

            <div class="border-t border-slate-100 pt-6 flex items-center justify-end gap-3">
                <a href="{{ route('dids.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-all">Cancel</a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs flex items-center gap-2 transition-all shadow-md shadow-blue-600/20">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>Create DID</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
