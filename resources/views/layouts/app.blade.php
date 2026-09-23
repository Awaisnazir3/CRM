<!DOCTYPE html>
<html lang="en" class="h-full bg-[#f0f4f9] text-slate-800">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DIDX Admin Panel') - Wholesale Phone Numbers Solution</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        navy: {
                            800: '#132c5b',
                            900: '#0d244f',
                            950: '#091a3a',
                        },
                        didx: {
                            blue: '#0052cc',
                            hover: '#0043a8',
                            light: '#e8f0fe',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f0f4f9;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .stat-card {
            background: #ffffff;
            border: 1px solid #e5e9f2;
            border-radius: 1rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.04), 0 1px 2px -1px rgba(0, 0, 0, 0.02);
            transition: all 0.2s ease;
        }
        .stat-card:hover {
            box-shadow: 0 4px 12px 0 rgba(0, 0, 0, 0.06);
            transform: translateY(-1px);
        }

        .badge-emerald {
            background-color: #ecfdf5;
            color: #059669;
            border: 1px solid #a7f3d0;
        }
        .badge-blue {
            background-color: #eff6ff;
            color: #2563eb;
            border: 1px solid #bfdbfe;
        }
        .badge-amber {
            background-color: #fffbeb;
            color: #d97706;
            border: 1px solid #fde68a;
        }
        .badge-purple {
            background-color: #faf5ff;
            color: #7c3aed;
            border: 1px solid #e9d5ff;
        }
        .badge-rose {
            background-color: #fff1f2;
            color: #e11d48;
            border: 1px solid #fecdd3;
        }
        .badge-slate {
            background-color: #f8fafc;
            color: #64748b;
            border: 1px solid #e2e8f0;
        }
    </style>
</head>
<body class="h-full flex overflow-hidden antialiased bg-[#f0f4f9] text-slate-800" x-data="{ sidebarOpen: true }">

    <!-- Sidebar Component (DIDX Navy Blue Theme) -->
    @include('layouts.sidebar')

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-[#f0f4f9]">
        <!-- Top Navbar Header -->
        @include('layouts.header')

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mx-6 mt-4 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2.5">
                    <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i>
                    <span class="text-xs font-semibold">{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="mx-6 mt-4 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2.5">
                    <i data-lucide="alert-triangle" class="w-4 h-4 text-rose-600"></i>
                    <span class="text-xs font-semibold">{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        @endif

        <!-- Main Page Container -->
        <main class="flex-1 overflow-y-auto p-5 md:p-7 space-y-6">
            @yield('content')
        </main>
    </div>

    <!-- Floating Chat Widget (bottom right like screenshot) -->
    <div class="fixed bottom-6 right-6 z-50">
        <button class="w-13 h-13 p-3.5 rounded-full bg-gradient-to-tr from-blue-600 to-sky-400 text-white shadow-xl shadow-blue-500/30 hover:scale-105 active:scale-95 transition-all flex items-center justify-center">
            <i data-lucide="message-circle" class="w-6 h-6 fill-current"></i>
        </button>
    </div>

    <!-- Initialize Lucide Icons -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
    @stack('scripts')
</body>
</html>
