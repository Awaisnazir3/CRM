<header class="h-16 px-6 bg-white border-b border-slate-200/90 flex items-center justify-between z-20 shadow-xs">
    <!-- Dual Search Bars -->
    <div class="flex items-center gap-4 flex-1 max-w-3xl">
        <!-- Search 1: DID / Order Search -->
        <form action="{{ route('dids.index') }}" method="GET" class="flex items-center rounded-lg border border-slate-300 overflow-hidden bg-slate-50 text-xs w-72 focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500">
            <div class="px-2.5 py-1.5 bg-slate-100 border-r border-slate-300 text-slate-700 font-medium flex items-center gap-1 cursor-pointer">
                <span>DID Number</span>
                <i data-lucide="chevron-down" class="w-3 h-3 text-slate-500"></i>
            </div>
            <input 
                type="text" 
                name="search" 
                placeholder="Search by DID or Order ID..." 
                class="flex-1 px-3 py-1.5 bg-white text-slate-800 placeholder-slate-400 focus:outline-none text-xs font-sans"
            >
            <button type="submit" class="px-3 py-1.5 bg-[#0d244f] hover:bg-[#132c5b] text-white flex items-center justify-center transition-colors">
                <i data-lucide="search" class="w-3.5 h-3.5"></i>
            </button>
        </form>

        <!-- Search 2: Quick Search -->
        <form action="{{ route('customers.index') }}" method="GET" class="flex items-center rounded-lg border border-slate-300 overflow-hidden bg-white text-xs flex-1 max-w-sm focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500">
            <input 
                type="text" 
                name="search" 
                placeholder="Quick search (name, email, phone, company...)" 
                class="flex-1 px-3 py-1.5 text-slate-800 placeholder-slate-400 focus:outline-none text-xs font-sans"
            >
            <button type="submit" class="px-3 py-1.5 bg-[#0d244f] hover:bg-[#132c5b] text-white flex items-center justify-center transition-colors">
                <i data-lucide="search" class="w-3.5 h-3.5"></i>
            </button>
        </form>
    </div>

    <!-- Right Header Icons & Profile -->
    <div class="flex items-center gap-5">
        <!-- Notification Icons -->
        <div class="flex items-center gap-4 text-slate-500">
            <button class="relative hover:text-slate-700 transition-colors" title="Notifications">
                <i data-lucide="bell" class="w-4 h-4"></i>
            </button>
            <button class="hover:text-slate-700 transition-colors" title="Messages">
                <i data-lucide="mail" class="w-4 h-4"></i>
            </button>
            <button onclick="window.location.reload()" class="hover:text-slate-700 transition-colors" title="Sync / Refresh">
                <i data-lucide="refresh-cw" class="w-4 h-4"></i>
            </button>
        </div>

        <div class="h-6 w-px bg-slate-200"></div>

        <!-- User Profile -->
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center">
                <i data-lucide="user" class="w-4 h-4"></i>
            </div>
            <div class="text-right leading-tight">
                <span class="text-xs font-bold text-slate-800 block">Test Account</span>
                <span class="text-[10px] text-slate-400 block font-mono">awaisn@didx.net</span>
                <span class="text-[9px] text-slate-400 block font-mono -mt-0.5">SIPmyNumber</span>
            </div>
        </div>
    </div>
</header>
