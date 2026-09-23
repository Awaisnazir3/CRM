<!DOCTYPE html>
<html lang="en" class="h-full bg-[#f0f4f9] text-slate-800">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DIDX Admin Panel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f0f4f9; }
    </style>
</head>
<body class="min-h-full flex items-center justify-center p-6 relative">
    <div class="w-full max-w-md relative z-10">
        <!-- Logo & Header -->
        <div class="text-center mb-6">
            <div class="inline-flex w-14 h-14 rounded-2xl bg-[#0d244f] items-center justify-center shadow-lg shadow-blue-950/20 mb-3 text-white font-black text-2xl tracking-wider">
                DIDX
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800">DIDX Admin Panel</h1>
            <p class="text-xs text-slate-500 mt-1">Wholesale Phone Numbers Solution</p>
            
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white border border-slate-200 text-[11px] text-slate-600 mt-3 shadow-xs">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span>Connected: <strong class="text-slate-800">192.168.88.119</strong> (didx2)</span>
            </div>
        </div>

        <!-- Login Card -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-8 shadow-md shadow-slate-200/50">
            @if(session('error'))
                <div class="mb-5 p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-medium flex items-center gap-2">
                    <i data-lucide="alert-circle" class="w-4 h-4"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if(session('warning'))
                <div class="mb-5 p-3 rounded-xl bg-amber-50 border border-amber-200 text-amber-700 text-xs font-medium flex items-center gap-2">
                    <i data-lucide="alert-triangle" class="w-4 h-4"></i>
                    <span>{{ session('warning') }}</span>
                </div>
            @endif

            <form action="{{ route('login.submit') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5 uppercase tracking-wider">Username / UID / Email</label>
                    <div class="relative">
                        <i data-lucide="user" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                        <input 
                            type="text" 
                            name="username" 
                            value="{{ old('username', 'admin') }}" 
                            required 
                            placeholder="e.g. admin or awais"
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition-all font-sans"
                        >
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5 uppercase tracking-wider">Password</label>
                    <div class="relative">
                        <i data-lucide="lock" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                        <input 
                            type="password" 
                            name="password" 
                            value="12343211"
                            required 
                            placeholder="Enter password"
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition-all font-sans"
                        >
                    </div>
                </div>

                <button 
                    type="submit" 
                    class="w-full py-2.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-md shadow-blue-600/20 transition-all active:scale-[0.98] flex items-center justify-center gap-2"
                >
                    <span>Sign In to Admin Panel</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </button>
            </form>

            <div class="relative my-6 text-center">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-200"></div></div>
                <span class="relative px-3 bg-white text-[11px] text-slate-400 font-medium uppercase tracking-wider">Quick Demo Login</span>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <a 
                    href="{{ route('login.quick', ['role' => 'admin']) }}" 
                    class="py-2 px-3 rounded-xl bg-slate-50 hover:bg-blue-50 border border-slate-200 hover:border-blue-300 text-xs font-semibold text-slate-700 hover:text-blue-700 flex items-center justify-center gap-2 transition-all group"
                >
                    <i data-lucide="shield-check" class="w-3.5 h-3.5 text-blue-600"></i>
                    <span>Super Admin</span>
                </a>
                <a 
                    href="{{ route('login.quick', ['role' => 'customer']) }}" 
                    class="py-2 px-3 rounded-xl bg-slate-50 hover:bg-blue-50 border border-slate-200 hover:border-blue-300 text-xs font-semibold text-slate-700 hover:text-blue-700 flex items-center justify-center gap-2 transition-all group"
                >
                    <i data-lucide="user-check" class="w-3.5 h-3.5 text-blue-600"></i>
                    <span>Customer Demo</span>
                </a>
            </div>
        </div>

        <p class="text-center text-xs text-slate-400 mt-6">
            DIDX2 Telecom CRM &bull; Live MySQL Connection
        </p>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
