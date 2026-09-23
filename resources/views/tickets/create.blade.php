@extends('layouts.app')

@section('title', 'Open Support Ticket')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center gap-2 text-xs text-slate-500 font-medium mb-1">
        <a href="{{ route('tickets.index') }}" class="text-blue-600 hover:underline flex items-center gap-1">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            <span>Back to Tickets</span>
        </a>
    </div>

    <div class="bg-white p-8 rounded-2xl border border-slate-200/90 shadow-xs">
        <div class="mb-6 pb-6 border-b border-slate-100">
            <h1 class="text-xl font-bold text-slate-800 flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <i data-lucide="life-buoy" class="w-4 h-4"></i>
                </div>
                <span>Open Support Ticket</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1 ml-10.5">Submit a new customer support ticket or technical inquiry</p>
        </div>

        <form action="{{ route('tickets.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5 uppercase tracking-wider">Customer UID / Account</label>
                    <input 
                        type="text" 
                        name="UID" 
                        value="{{ request('uid') }}" 
                        required 
                        placeholder="Enter Customer UID (e.g. 10001)" 
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white font-mono transition-all"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5 uppercase tracking-wider">Associated DID (Optional)</label>
                    <input 
                        type="text" 
                        name="DID" 
                        placeholder="e.g. 12025550199" 
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white font-mono transition-all"
                    >
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5 uppercase tracking-wider">Inquiry Type</label>
                <select name="Type" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white transition-all">
                    <option value="TECH">Technical / Routing Issue</option>
                    <option value="BILL">Billing & Payment Dispute</option>
                    <option value="LNP">Number Porting Inquiry</option>
                    <option value="GEN">General Question</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5 uppercase tracking-wider">Complaint / Problem Description</label>
                <textarea 
                    name="Complain" 
                    rows="5" 
                    required 
                    placeholder="Provide full details of the issue or inquiry..." 
                    class="w-full p-4 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white font-sans transition-all"
                ></textarea>
            </div>

            <div class="border-t border-slate-100 pt-6 flex items-center justify-end gap-3">
                <a href="{{ route('tickets.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition-all">Cancel</a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs flex items-center gap-2 transition-all shadow-md shadow-blue-600/20">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>Submit Ticket</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
