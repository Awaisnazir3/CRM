@extends('layouts.app')

@section('title', 'Bulk Allocation')

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-xs text-slate-500 font-medium">
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline flex items-center gap-1">
            <i data-lucide="home" class="w-3.5 h-3.5"></i>
            <span>Dashboard</span>
        </a>
        <span>&gt;</span>
        <a href="{{ route('dids.index') }}" class="text-blue-600 hover:underline">DIDs Management</a>
        <span>&gt;</span>
        <span class="text-slate-800 font-semibold">Bulk Allocation</span>
    </div>

    <!-- Header Banner -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                <i data-lucide="layers" class="w-5 h-5"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Bulk DID Allocation</h1>
                <p class="text-xs text-slate-400 mt-0.5">Allocate multiple DID phone numbers simultaneously to an enterprise buyer</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="max-w-3xl mx-auto bg-white rounded-2xl p-8 border border-slate-200/90 shadow-xs">
        <form action="{{ route('dids.bulk-allocation.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                    Customer / Buyer Order ID (OID) <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="OID" 
                    required 
                    placeholder="Enter Buyer Customer OID (e.g. 700292)" 
                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white font-mono"
                >
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                    Default Ring-To Destination URL
                </label>
                <input 
                    type="text" 
                    name="RingTo" 
                    value="echo@us1.didx.net" 
                    placeholder="e.g. echo@us1.didx.net or SIP/customer_gateway" 
                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white font-mono"
                >
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                    DID Numbers List (One number per line) <span class="text-rose-500">*</span>
                </label>
                <textarea 
                    name="dids_list" 
                    rows="8" 
                    required 
                    placeholder="12025550199&#10;12025550200&#10;442079460912&#10;448009020623" 
                    class="w-full p-4 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white font-mono"
                ></textarea>
                <p class="text-[11px] text-slate-400 mt-1">Paste multiple E.164 formatted numbers.</p>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('dids.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition-all">Cancel</a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#0d244f] hover:bg-[#132c5b] text-white font-bold text-xs flex items-center gap-2 transition-all shadow-sm">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>Execute Bulk Allocation</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
