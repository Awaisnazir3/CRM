@extends('layouts.app')

@section('title', 'Node Stats Report')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow-md shadow-blue-500/20">
            <i data-lucide="layers" class="w-6 h-6"></i>
        </div>
        <div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">Node Stats Report</h1>
            <p class="text-xs text-slate-500 mt-0.5">Showing stats for {{ $formattedDate }}</p>
        </div>
    </div>

    <!-- Filter Form Bar -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs">
        <form action="{{ route('tools.node-stats') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
            <!-- Year -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Year</label>
                <select name="year" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white transition-all font-sans font-medium">
                    @foreach(range(2026, 2020) as $y)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Month -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Month</label>
                <select name="month" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white transition-all font-sans font-medium">
                    @php
                        $months = [
                            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
                        ];
                    @endphp
                    @foreach($months as $num => $name)
                        <option value="{{ $num }}" {{ $month == $num ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Day -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Day</label>
                <select name="day" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white transition-all font-sans font-medium">
                    @foreach(range(1, 31) as $d)
                        <option value="{{ $d }}" {{ $day == $d ? 'selected' : '' }}>{{ $d }}</option>
                    @endforeach
                </select>
            </div>

            <!-- System Box -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">System Box</label>
                <select name="system_box" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 focus:outline-none focus:border-blue-500 focus:bg-white transition-all font-sans font-medium">
                    <option value="all" {{ $selectedSystem === 'all' ? 'selected' : '' }}>All Systems</option>
                    @foreach($knownBoxes as $box)
                        <option value="{{ $box }}" {{ $selectedSystem === $box ? 'selected' : '' }}>{{ $box }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="w-full py-2.5 px-5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs flex items-center justify-center gap-2 transition-all shadow-md shadow-blue-600/20 active:scale-95">
                    <span>&#9660; Apply Filters</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Node Statistics Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <!-- Card Header with CSV Export -->
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i data-lucide="layout-grid" class="w-4 h-4 text-slate-700"></i>
                <h2 class="text-sm font-bold text-slate-800">Node Statistics</h2>
                <span class="text-xs text-slate-400 font-normal italic ml-1">Loaded in {{ $loadTimeText }}</span>
            </div>

            <div>
                <a href="{{ route('tools.node-stats', array_merge(request()->query(), ['export' => 'csv'])) }}" class="px-3.5 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100 font-semibold text-xs inline-flex items-center gap-1.5 transition-all shadow-2xs">
                    <i data-lucide="file-spreadsheet" class="w-3.5 h-3.5"></i>
                    <span>Export CSV</span>
                </a>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs font-sans">
                <thead>
                    <tr class="bg-slate-50/75 text-slate-600 border-b border-slate-200 font-semibold text-[11px]">
                        <th class="py-3.5 px-6">System</th>
                        <th class="py-3.5 px-6 text-center">Total Vendors</th>
                        <th class="py-3.5 px-6 text-center">Total DIDs</th>
                        <th class="py-3.5 px-6 text-center">Total Calls</th>
                        <th class="py-3.5 px-6 text-center">Actual Duration</th>
                        <th class="py-3.5 px-6 text-center">Billed Duration</th>
                        <th class="py-3.5 px-6 text-right">Billed Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($nodeStats as $stat)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-3.5 px-6 font-medium">
                                <a href="{{ route('cdrs.index', ['search' => $stat->SystemBox]) }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                    {{ $stat->SystemBox }}
                                </a>
                            </td>
                            <td class="py-3.5 px-6 text-center text-slate-700 font-medium">
                                {{ number_format($stat->total_vendors) }}
                            </td>
                            <td class="py-3.5 px-6 text-center">
                                <a href="{{ route('dids.index', ['search' => $stat->SystemBox]) }}" class="text-indigo-600 font-semibold hover:underline">
                                    {{ number_format($stat->total_dids) }}
                                </a>
                            </td>
                            <td class="py-3.5 px-6 text-center text-slate-700 font-medium font-mono">
                                {{ number_format($stat->total_calls) }}
                            </td>
                            <td class="py-3.5 px-6 text-center text-slate-600 font-medium">
                                {{ number_format($stat->actual_duration_min, 1) }} min.
                            </td>
                            <td class="py-3.5 px-6 text-center text-slate-600 font-medium">
                                {{ number_format(round($stat->billed_duration_min)) }} min.
                            </td>
                            <td class="py-3.5 px-6 text-right text-slate-800 font-bold font-mono">
                                ${{ number_format($stat->billed_amount, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400 font-sans text-xs">
                                No statistics found for the selected date.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <!-- Totals Footer Row -->
                <tfoot>
                    <tr class="bg-slate-50/90 border-t-2 border-slate-200 text-slate-800 font-bold text-xs">
                        <td class="py-4 px-6 text-slate-700">Total</td>
                        <td class="py-4 px-6 text-center">{{ number_format($totals['total_vendors']) }}</td>
                        <td class="py-4 px-6 text-center text-indigo-700">{{ number_format($totals['total_dids']) }}</td>
                        <td class="py-4 px-6 text-center font-mono">{{ number_format($totals['total_calls']) }}</td>
                        <td class="py-4 px-6 text-center">{{ number_format(round($totals['actual_duration_min'])) }} min.</td>
                        <td class="py-4 px-6 text-center">{{ number_format(round($totals['billed_duration_min'])) }} min.</td>
                        <td class="py-4 px-6 text-right text-slate-900 font-mono text-sm">${{ number_format($totals['billed_amount'], 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
