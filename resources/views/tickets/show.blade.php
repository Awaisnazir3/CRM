@extends('layouts.app')

@section('title', "Ticket #{$ticket->ComplainID}")

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center gap-2 text-xs text-slate-500 font-medium mb-1">
        <a href="{{ route('tickets.index') }}" class="text-blue-600 hover:underline flex items-center gap-1">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            <span>Back to Tickets</span>
        </a>
        <span>&gt;</span>
        <span class="text-slate-600">Support Ticket Thread</span>
    </div>

    <!-- Ticket Header Card -->
    <div class="p-6 rounded-2xl bg-white border border-slate-200/90 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <span class="text-xl font-bold text-amber-600 font-mono">#{{ $ticket->ComplainID }}</span>
                <span class="px-2.5 py-0.5 rounded-md text-xs font-semibold {{ $ticket->status_badge }}">
                    {{ $ticket->status_label }}
                </span>
                <span class="text-xs text-slate-400 font-mono">{{ $ticket->DateTime }}</span>
            </div>
            <p class="text-xs text-slate-600">
                Customer UID: <a href="{{ route('customers.show', $ticket->UID) }}" class="text-blue-600 hover:underline font-mono font-bold">{{ $ticket->UID }}</a>
                @if($ticket->DID)
                    &bull; Associated DID: <span class="text-blue-600 font-mono">+{{ $ticket->DID }}</span>
                @endif
            </p>
        </div>

        <form action="{{ route('tickets.toggle-status', $ticket->ComplainID) }}" method="POST">
            @csrf
            <button type="submit" class="px-4 py-2 rounded-xl {{ $ticket->IsResolved ? 'bg-amber-50 text-amber-700 border border-amber-200 hover:bg-amber-100' : 'bg-emerald-600 hover:bg-emerald-700 text-white font-semibold' }} text-xs flex items-center gap-2 transition-all shadow-xs">
                <i data-lucide="{{ $ticket->IsResolved ? 'rotate-ccw' : 'check-circle' }}" class="w-4 h-4"></i>
                <span>{{ $ticket->IsResolved ? 'Reopen Ticket' : 'Mark as Resolved' }}</span>
            </button>
        </form>
    </div>

    <!-- Original Complaint Body -->
    <div class="p-6 rounded-2xl bg-white border border-slate-200/90 shadow-xs space-y-2">
        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Customer Inquiry / Issue Description</span>
        <div class="text-sm text-slate-800 leading-relaxed whitespace-pre-line p-4 rounded-xl bg-slate-50 border border-slate-200 font-sans">
            {{ $ticket->Complain }}
        </div>
    </div>

    <!-- Conversation Stream / Threads -->
    <div class="space-y-4">
        <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
            <i data-lucide="messages-square" class="w-4 h-4 text-blue-600"></i>
            <span>Conversation & Remarks Thread ({{ count($ticket->threads) }})</span>
        </h2>

        @forelse($ticket->threads as $thread)
            <div class="p-5 rounded-2xl bg-white border border-slate-200/90 shadow-xs space-y-2 border-l-4 {{ str_contains(strtolower($thread->WrittenBy ?? ''), 'agent') || str_contains(strtolower($thread->WrittenBy ?? ''), 'admin') ? 'border-blue-600' : 'border-slate-400' }}">
                <div class="flex items-center justify-between text-xs">
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-slate-800">{{ $thread->WrittenBy ?: 'Support Agent' }}</span>
                        <span class="text-[11px] text-slate-400 font-mono">{{ $thread->date }}</span>
                    </div>
                    @if($thread->SentToClient)
                        <span class="text-[10px] px-1.5 py-0.5 rounded bg-emerald-50 text-emerald-700 font-semibold border border-emerald-200">Delivered to Client</span>
                    @endif
                </div>

                <div class="text-xs text-slate-700 whitespace-pre-line font-sans pt-1">
                    {{ $thread->Remarks }}
                </div>
            </div>
        @empty
            <div class="p-6 rounded-2xl bg-white border border-slate-200 text-center text-xs text-slate-400">
                No replies or follow-up remarks in this thread yet.
            </div>
        @endforelse
    </div>

    <!-- Reply Form -->
    <div class="p-6 rounded-2xl bg-white border border-slate-200/90 shadow-xs">
        <h3 class="text-sm font-bold text-slate-800 mb-3 flex items-center gap-2">
            <i data-lucide="send" class="w-4 h-4 text-blue-600"></i>
            <span>Post Reply / Follow-up Note</span>
        </h3>

        <form action="{{ route('tickets.reply', $ticket->ComplainID) }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <textarea 
                    name="remarks" 
                    rows="4" 
                    required 
                    placeholder="Type reply message or internal support remarks..."
                    class="w-full p-4 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:border-blue-500 placeholder-slate-400 font-sans"
                ></textarea>
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 text-xs text-slate-600 cursor-pointer">
                    <input type="checkbox" name="resolve" value="1" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <span>Resolve ticket upon sending reply</span>
                </label>

                <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs flex items-center gap-2 transition-all shadow-md shadow-blue-600/20">
                    <i data-lucide="send" class="w-3.5 h-3.5"></i>
                    <span>Send Reply</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
