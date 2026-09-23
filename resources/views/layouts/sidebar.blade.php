<aside class="w-64 flex-shrink-0 bg-[#0d244f] text-white flex flex-col justify-between transition-all duration-300 z-30 select-none shadow-xl">
    <!-- Top Branding & Navigation -->
    <div class="overflow-y-auto flex-1 custom-scrollbar">
        <!-- Logo Header -->
        <div class="h-16 px-5 flex items-center border-b border-white/10 bg-[#0a1e43]">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                <span class="font-black text-lg tracking-wider text-white">DIDX</span>
                <span class="text-sm font-semibold text-slate-300">Admin Panel</span>
            </a>
        </div>

        <!-- Search Menu Input -->
        <div class="p-3.5">
            <div class="relative">
                <i data-lucide="search" class="w-3.5 h-3.5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                <input 
                    type="text" 
                    placeholder="Search menu..." 
                    class="w-full pl-8 pr-3 py-1.5 bg-[#132c5b] border border-white/10 rounded-lg text-xs text-white placeholder-slate-400 focus:outline-none focus:border-blue-400 font-sans"
                >
            </div>
        </div>

        @php
            $currentGroup = 'dids';
            if (request()->routeIs('dashboard')) $currentGroup = 'dashboard';
            elseif (request()->routeIs('dids.*')) $currentGroup = 'dids';
            elseif (request()->routeIs('tools.*') || request()->is('reports/node-stats')) $currentGroup = 'tools';
            elseif (request()->routeIs('customers.*') || request()->is('users*')) $currentGroup = 'users';
            elseif (request()->routeIs('billing.*') || request()->routeIs('reports.*') || request()->routeIs('orders.*')) $currentGroup = 'finance';
            elseif (request()->routeIs('vendors.*')) $currentGroup = 'vendors';
            elseif (request()->routeIs('tickets.*')) $currentGroup = 'support';
            elseif (request()->routeIs('lnp.*')) $currentGroup = 'approvals';
        @endphp

        <!-- Navigation Menu Accordion -->
        <nav class="px-2.5 space-y-0.5 text-xs font-medium pb-6" x-data="{ openGroup: '{{ $currentGroup }}' }">
            <!-- 1. Dashboard -->
            <div>
                <a href="{{ route('dashboard') }}" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-[#183a75] text-white font-bold' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <i data-lucide="layout-dashboard" class="w-4 h-4 text-slate-300"></i>
                        <span>Dashboard</span>
                    </div>
                </a>
            </div>

            <!-- 2. Signup Management -->
            <div>
                <button @click="openGroup = openGroup === 'signup' ? '' : 'signup'" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition-colors text-slate-300 hover:bg-white/5 hover:text-white">
                    <div class="flex items-center gap-3">
                        <i data-lucide="user-plus" class="w-4 h-4 text-slate-300"></i>
                        <span>Signup Management</span>
                    </div>
                    <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-400 transition-transform" :class="openGroup === 'signup' ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="openGroup === 'signup'" class="pl-9 pr-2 py-1 space-y-1 text-slate-300" x-cloak>
                    <a href="{{ route('customers.index') }}" class="block py-1.5 px-2 rounded hover:text-white hover:bg-white/5 {{ request()->routeIs('customers.index') ? 'text-blue-300 font-bold' : '' }}">Customer Directory</a>
                    <a href="{{ route('customers.create') }}" class="block py-1.5 px-2 rounded hover:text-white hover:bg-white/5 {{ request()->routeIs('customers.create') ? 'text-blue-300 font-bold' : '' }}">Add Customer</a>
                </div>
            </div>

            <!-- 3. DIDs Management (Active in Screenshots) -->
            <div>
                <button @click="openGroup = openGroup === 'dids' ? '' : 'dids'" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('dids.*') ? 'bg-[#183a75] text-white font-bold' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <i data-lucide="phone-call" class="w-4 h-4 text-blue-400"></i>
                        <span>DIDs Management</span>
                    </div>
                    <i data-lucide="chevron-up" class="w-3.5 h-3.5 text-slate-400 transition-transform" :class="openGroup === 'dids' ? '' : 'rotate-180'"></i>
                </button>
                <div x-show="openGroup === 'dids'" class="pl-4 pr-2 py-1 space-y-0.5 text-slate-300" x-cloak>
                    <!-- Allocate DID -->
                    <a href="{{ route('dids.allocate') }}" class="flex items-center gap-2 py-1.5 px-2.5 rounded-lg transition-colors {{ request()->routeIs('dids.allocate') ? 'bg-white/15 text-white font-bold border-l-2 border-blue-400' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <i data-lucide="plus-circle" class="w-3.5 h-3.5 text-slate-400"></i>
                        <span>Allocate DID</span>
                    </a>
                    <!-- Bulk Allocation -->
                    <a href="{{ route('dids.bulk-allocation') }}" class="flex items-center gap-2 py-1.5 px-2.5 rounded-lg transition-colors {{ request()->routeIs('dids.bulk-allocation') ? 'bg-white/15 text-white font-bold border-l-2 border-blue-400' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <i data-lucide="layers" class="w-3.5 h-3.5 text-slate-400"></i>
                        <span>Bulk Allocation</span>
                    </a>
                    <!-- Allocation History -->
                    <a href="{{ route('dids.allocation-history') }}" class="flex items-center gap-2 py-1.5 px-2.5 rounded-lg transition-colors {{ request()->routeIs('dids.allocation-history') ? 'bg-white/15 text-white font-bold border-l-2 border-blue-400' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <i data-lucide="history" class="w-3.5 h-3.5 text-slate-400"></i>
                        <span>Allocation History</span>
                    </a>
                    <!-- Manage DIDs -->
                    <a href="{{ route('dids.index') }}" class="flex items-center gap-2 py-1.5 px-2.5 rounded-lg transition-colors {{ request()->routeIs('dids.index') ? 'bg-white/15 text-white font-bold border-l-2 border-blue-400' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <i data-lucide="sliders-horizontal" class="w-3.5 h-3.5 text-slate-400"></i>
                        <span>Manage DIDs</span>
                    </a>
                    <!-- Requested DIDs -->
                    <a href="{{ route('dids.requested') }}" class="flex items-center gap-2 py-1.5 px-2.5 rounded-lg transition-colors {{ request()->routeIs('dids.requested') ? 'bg-white/15 text-white font-bold border-l-2 border-blue-400' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <i data-lucide="inbox" class="w-3.5 h-3.5 text-slate-400"></i>
                        <span>Requested DIDs</span>
                    </a>
                    <!-- Approval Queue -->
                    <a href="{{ route('dids.approval-queue') }}" class="flex items-center gap-2 py-1.5 px-2.5 rounded-lg transition-colors {{ request()->routeIs('dids.approval-queue') ? 'bg-white/15 text-white font-bold border-l-2 border-blue-400' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <i data-lucide="check-square" class="w-3.5 h-3.5 text-slate-400"></i>
                        <span>Approval Queue</span>
                    </a>
                    <!-- Ready to Commit -->
                    <a href="{{ route('dids.ready-to-commit') }}" class="flex items-center gap-2 py-1.5 px-2.5 rounded-lg transition-colors {{ request()->routeIs('dids.ready-to-commit') ? 'bg-white/15 text-white font-bold border-l-2 border-blue-400' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <i data-lucide="send" class="w-3.5 h-3.5 text-slate-400"></i>
                        <span>Ready to Commit</span>
                    </a>
                    <!-- Monthly Reconciliation -->
                    <a href="{{ route('dids.monthly-reconciliation') }}" class="flex items-center gap-2 py-1.5 px-2.5 rounded-lg transition-colors {{ request()->routeIs('dids.monthly-reconciliation') ? 'bg-white/15 text-white font-bold border-l-2 border-blue-400' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <i data-lucide="calculator" class="w-3.5 h-3.5 text-slate-400"></i>
                        <span>Monthly Reconciliation</span>
                    </a>
                </div>
            </div>

            <!-- 4. Payment Management -->
            <div>
                <button @click="openGroup = openGroup === 'payment' ? '' : 'payment'" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition-colors text-slate-300 hover:bg-white/5 hover:text-white">
                    <div class="flex items-center gap-3">
                        <i data-lucide="credit-card" class="w-4 h-4 text-slate-300"></i>
                        <span>Payment Management</span>
                    </div>
                    <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-400 transition-transform" :class="openGroup === 'payment' ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="openGroup === 'payment'" class="pl-9 pr-2 py-1 space-y-1 text-slate-300" x-cloak>
                    <a href="{{ route('billing.index', ['tab' => 'transactions']) }}" class="block py-1.5 px-2 rounded hover:text-white hover:bg-white/5 {{ request()->routeIs('billing.index') ? 'text-blue-300 font-bold' : '' }}">Transactions</a>
                    <a href="{{ route('orders.index') }}" class="block py-1.5 px-2 rounded hover:text-white hover:bg-white/5 {{ request()->routeIs('orders.*') ? 'text-blue-300 font-bold' : '' }}">Orders</a>
                    <a href="{{ route('reports.index') }}" class="block py-1.5 px-2 rounded hover:text-white hover:bg-white/5">Billing Reports</a>
                </div>
            </div>

            <!-- 5. Ticket Management -->
            <div>
                <button @click="openGroup = openGroup === 'tickets' ? '' : 'tickets'" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition-colors text-slate-300 hover:bg-white/5 hover:text-white">
                    <div class="flex items-center gap-3">
                        <i data-lucide="life-buoy" class="w-4 h-4 text-slate-300"></i>
                        <span>Ticket Management</span>
                    </div>
                    <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-400 transition-transform" :class="openGroup === 'tickets' ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="openGroup === 'tickets'" class="pl-9 pr-2 py-1 space-y-1 text-slate-300" x-cloak>
                    <a href="{{ route('tickets.index', ['status' => 'open']) }}" class="block py-1.5 px-2 rounded hover:text-white hover:bg-white/5">Open Complaints</a>
                    <a href="{{ route('tickets.index', ['status' => 'resolved']) }}" class="block py-1.5 px-2 rounded hover:text-white hover:bg-white/5">Resolved Tickets</a>
                    <a href="{{ route('tickets.create') }}" class="block py-1.5 px-2 rounded hover:text-white hover:bg-white/5">Open New Ticket</a>
                </div>
            </div>

            <!-- 6. Rates Management -->
            <div>
                <a href="{{ route('reports.index') }}" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition-colors text-slate-300 hover:bg-white/5 hover:text-white">
                    <div class="flex items-center gap-3">
                        <i data-lucide="tag" class="w-4 h-4 text-slate-300"></i>
                        <span>Rates Management</span>
                    </div>
                </a>
            </div>

            <!-- 7. Permission Management -->
            <div>
                <a href="{{ route('customers.index') }}" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition-colors text-slate-300 hover:bg-white/5 hover:text-white">
                    <div class="flex items-center gap-3">
                        <i data-lucide="shield-check" class="w-4 h-4 text-slate-300"></i>
                        <span>Permission Management</span>
                    </div>
                </a>
            </div>

            <!-- 8. Document Management -->
            <div>
                <a href="{{ route('customers.index') }}" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition-colors text-slate-300 hover:bg-white/5 hover:text-white">
                    <div class="flex items-center gap-3">
                        <i data-lucide="file-text" class="w-4 h-4 text-slate-300"></i>
                        <span>Document Management</span>
                    </div>
                </a>
            </div>

            <!-- 9. Table Migration & SIP -->
            <div>
                <a href="{{ route('servers.index') }}" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition-colors text-slate-300 hover:bg-white/5 hover:text-white">
                    <div class="flex items-center gap-3">
                        <i data-lucide="database" class="w-4 h-4 text-slate-300"></i>
                        <span>Table Migration</span>
                    </div>
                </a>
            </div>

            <!-- 10. Email Templates -->
            <div>
                <a href="#" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition-colors text-slate-300 hover:bg-white/5 hover:text-white">
                    <div class="flex items-center gap-3">
                        <i data-lucide="mail" class="w-4 h-4 text-slate-300"></i>
                        <span>Email Templates</span>
                    </div>
                </a>
            </div>

            <!-- 11. Finance -->
            <div>
                <a href="{{ route('billing.index') }}" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition-colors text-slate-300 hover:bg-white/5 hover:text-white">
                    <div class="flex items-center gap-3">
                        <i data-lucide="dollar-sign" class="w-4 h-4 text-slate-300"></i>
                        <span>Finance</span>
                    </div>
                </a>
            </div>

            <!-- 12. Vendors Management -->
            <div>
                <a href="{{ route('vendors.index') }}" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('vendors.*') ? 'bg-[#183a75] text-white font-bold' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <i data-lucide="handshake" class="w-4 h-4 text-slate-300"></i>
                        <span>Vendors Management</span>
                    </div>
                </a>
            </div>

            <!-- 13. Approvals (LNP) -->
            <div>
                <a href="{{ route('lnp.index') }}" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('lnp.*') ? 'bg-[#183a75] text-white font-bold' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <i data-lucide="check-circle" class="w-4 h-4 text-slate-300"></i>
                        <span>Approvals</span>
                    </div>
                </a>
            </div>

            <!-- 14. Support & Requests -->
            <div>
                <a href="{{ route('tickets.index') }}" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('tickets.*') ? 'bg-[#183a75] text-white font-bold' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <i data-lucide="headphones" class="w-4 h-4 text-slate-300"></i>
                        <span>Support & Requests</span>
                    </div>
                </a>
            </div>

            <!-- 15. Users -->
            <div>
                <a href="{{ route('customers.index') }}" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition-colors text-slate-300 hover:bg-white/5 hover:text-white">
                    <div class="flex items-center gap-3">
                        <i data-lucide="users-2" class="w-4 h-4 text-slate-300"></i>
                        <span>Users</span>
                    </div>
                </a>
            </div>

            <!-- 16. Tools -->
            <div>
                <button @click="openGroup = openGroup === 'tools' ? '' : 'tools'" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('tools.*') ? 'bg-[#183a75] text-white font-bold' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <i data-lucide="wrench" class="w-4 h-4 text-blue-400"></i>
                        <span>Tools</span>
                    </div>
                    <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-400 transition-transform" :class="openGroup === 'tools' ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="openGroup === 'tools'" class="pl-4 pr-2 py-1 space-y-0.5 text-slate-300" x-cloak>
                    <a href="{{ route('tools.node-stats') }}" class="flex items-center gap-2 py-1.5 px-2.5 rounded-lg transition-colors {{ request()->routeIs('tools.node-stats') ? 'bg-white/15 text-white font-bold border-l-2 border-blue-400' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                        <i data-lucide="credit-card" class="w-3.5 h-3.5 text-blue-300"></i>
                        <span>Node Stats Report</span>
                    </a>
                    <a href="{{ route('tools.api-logs') }}" class="flex items-center gap-2 py-1.5 px-2.5 rounded-lg transition-colors text-slate-300 hover:bg-white/5 hover:text-white">
                        <i data-lucide="code-2" class="w-3.5 h-3.5 text-slate-400"></i>
                        <span>API Users Log</span>
                    </a>
                    <a href="{{ route('tools.buyer-history') }}" class="flex items-center gap-2 py-1.5 px-2.5 rounded-lg transition-colors text-slate-300 hover:bg-white/5 hover:text-white">
                        <i data-lucide="history" class="w-3.5 h-3.5 text-slate-400"></i>
                        <span>Buyer History</span>
                    </a>
                </div>
            </div>

            <!-- 17. Integrations -->
            <div>
                <a href="{{ route('servers.index') }}" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition-colors text-slate-300 hover:bg-white/5 hover:text-white">
                    <div class="flex items-center gap-3">
                        <i data-lucide="plug" class="w-4 h-4 text-slate-300"></i>
                        <span>Integrations</span>
                    </div>
                </a>
            </div>

            <!-- 18. Information -->
            <div>
                <a href="{{ route('reports.index') }}" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition-colors text-slate-300 hover:bg-white/5 hover:text-white">
                    <div class="flex items-center gap-3">
                        <i data-lucide="info" class="w-4 h-4 text-slate-300"></i>
                        <span>Information</span>
                    </div>
                </a>
            </div>

            <!-- 19. Content Management -->
            <div>
                <a href="#" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition-colors text-slate-300 hover:bg-white/5 hover:text-white">
                    <div class="flex items-center gap-3">
                        <i data-lucide="layout-template" class="w-4 h-4 text-slate-300"></i>
                        <span>Content Management</span>
                    </div>
                </a>
            </div>
        </nav>
    </div>

    <!-- Bottom User Info -->
    <div class="p-3 border-t border-white/10 bg-[#091a3a]">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2.5 min-w-0">
                <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-xs">
                    {{ substr(session('crm_user.name', 'Awais'), 0, 1) }}
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-white truncate">{{ session('crm_user.name', 'Awais Nazeer') }}</p>
                    <p class="text-[10px] text-slate-400 truncate">192.168.88.119 (didx2)</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" title="Logout" class="p-1.5 text-slate-400 hover:text-rose-400 rounded-lg hover:bg-white/5 transition-colors">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                </button>
            </form>
        </div>
    </div>
</aside>
