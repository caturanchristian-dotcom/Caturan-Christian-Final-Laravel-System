@extends('layouts.main')

@section('title', 'Global Oversight | Command Center')

@section('content')
<div class="animate-in fade-in duration-700 pb-20">
    <!-- Header Section -->
    <div class="bg-white border-b border-slate-100 shadow-sm relative z-20">
        <div class="max-w-7xl mx-auto px-8 py-12">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-8">
                <div class="space-y-2">
                    <div class="flex items-center gap-3">
                        <div class="flex -space-x-2">
                            <div class="w-6 h-6 rounded-full bg-emerald-500 border-2 border-white"></div>
                            <div class="w-6 h-6 rounded-full bg-blue-500 border-2 border-white"></div>
                            <div class="w-6 h-6 rounded-full bg-slate-200 border-2 border-white flex items-center justify-center text-[8px] font-black text-slate-500">12+</div>
                        </div>
                        <span class="text-xs font-black text-slate-400 uppercase tracking-widest">Network Nodes Monitoring</span>
                    </div>
                    <h1 class="text-5xl font-black text-slate-900 tracking-tighter">System Oversight</h1>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="bg-slate-900 text-white p-6 rounded-[32px] shadow-2xl flex items-center gap-6 min-w-[280px]">
                        <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-green-400">
                            <i class="fas fa-chart-line text-xl"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest opacity-50">Global Revenue</p>
                            <p class="text-2xl font-black">₱{{ number_format($stats['total_revenue'], 0) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-8 py-12">
        <!-- Main Dashboard Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            
            <!-- Left Col: Key Metrics -->
            <div class="lg:col-span-2 space-y-10">
                <!-- Bento Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-8 rounded-[40px] border border-slate-100 shadow-sm dashboard-card">
                        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-6"><i class="fas fa-users-viewfinder"></i></div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Users</p>
                        <p class="text-3xl font-black text-slate-900">{{ $stats['total_users'] }}</p>
                    </div>
                    <div class="bg-white p-8 rounded-[40px] border border-slate-100 shadow-sm dashboard-card">
                        <div class="w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center mb-6"><i class="fas fa-tractor"></i></div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Verified Farmers</p>
                        <p class="text-3xl font-black text-slate-900">{{ $stats['active_farmers'] }}</p>
                    </div>
                    <div class="bg-white p-8 rounded-[40px] border border-slate-100 shadow-sm dashboard-card">
                        <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center mb-6"><i class="fas fa-shuttle-space"></i></div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Trades</p>
                        <p class="text-3xl font-black text-slate-900">{{ $stats['total_orders'] }}</p>
                    </div>
                </div>

                <!-- Revenue Chart -->
                <div class="bg-white p-10 rounded-[50px] border border-slate-100 shadow-sm">
                    <div class="flex justify-between items-center mb-10">
                        <div>
                            <h3 class="text-2xl font-black text-slate-900 tracking-tight">Financial Trajectory</h3>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Global platform volume</p>
                        </div>
                        <span class="px-4 py-2 rounded-2xl bg-slate-50 text-slate-400 text-[10px] font-black uppercase tracking-widest">Protocol: Active</span>
                    </div>
                    <div id="revenueChart" class="min-h-[400px]"></div>
                </div>

                <!-- Recent Transactions -->
                <div class="bg-white rounded-[50px] border border-slate-100 shadow-sm overflow-hidden">
                    <div class="p-10 border-b border-slate-50 flex justify-between items-center">
                        <h3 class="text-2xl font-black text-slate-900 tracking-tight">Recent Trades</h3>
                        <a href="{{ route('admin.orders.index') }}" class="text-[10px] font-black text-green-600 uppercase tracking-widest hover:underline decoration-2">Full Audit Log</a>
                    </div>
                    <div class="p-0">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                <tr>
                                    <th class="px-10 py-6">Protocol ID</th>
                                    <th class="px-10 py-6">Counterparty</th>
                                    <th class="px-10 py-6">Value</th>
                                    <th class="px-10 py-6 text-right">State</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50 text-sm font-semibold">
                                @forelse($recent_transactions as $order)
                                    <tr class="hover:bg-slate-50/40 transition-colors group">
                                        <td class="px-10 py-8 text-slate-900 font-black">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                        <td class="px-10 py-8 text-slate-600">{{ $order->user->name }}</td>
                                        <td class="px-10 py-8 text-slate-900 font-black">₱{{ number_format($order->total_amount, 2) }}</td>
                                        <td class="px-10 py-8 text-right">
                                            <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest 
                                                {{ $order->status == 'delivered' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="p-20 text-center text-slate-300 italic">No trades recorded in current cycle.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Col: Intelligence & Top Suppliers -->
            <div class="space-y-10">
                <!-- User Distribution Chart -->
                <div class="bg-white p-10 rounded-[50px] border border-slate-100 shadow-sm">
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight mb-8">Node Distribution</h3>
                    <div id="userChart" class="min-h-[300px]"></div>
                </div>

                <!-- Top Performing Nodes -->
                <div class="bg-white rounded-[50px] border border-slate-100 shadow-sm overflow-hidden">
                    <div class="p-10 border-b border-slate-50 flex justify-between items-center bg-slate-900 text-white">
                        <h3 class="text-lg font-black tracking-tight">Top Suppliers</h3>
                        <i class="fas fa-crown text-amber-400"></i>
                    </div>
                    <div class="divide-y divide-slate-50">
                        @foreach($top_suppliers as $farmer)
                            <a href="{{ route('admin.suppliers.show', $farmer->id) }}" class="p-8 flex items-center justify-between group hover:bg-slate-50 transition-all">
                                <div class="flex items-center gap-5">
                                    <div class="w-12 h-12 bg-slate-900 rounded-2xl flex items-center justify-center text-white font-black text-lg group-hover:scale-110 transition-transform">
                                        {{ strtoupper(substr($farmer->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h4 class="font-black text-slate-900 text-sm truncate max-w-[140px]">{{ $farmer->farm_name ?? $farmer->name }}</h4>
                                        <p class="text-[10px] text-green-600 font-black uppercase tracking-widest">₱{{ number_format($farmer->total_revenue ?? 0, 0) }}</p>
                                    </div>
                                </div>
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-slate-200 group-hover:text-green-600 group-hover:bg-green-50 transition-all">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Pending Actions Alert -->
                @if($stats['pending_approvals'] > 0)
                    <div class="p-10 bg-amber-500 rounded-[50px] text-white shadow-2xl shadow-amber-200 animate-in slide-in-from-right duration-500">
                        <div class="flex items-start gap-6">
                            <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center shrink-0">
                                <i class="fas fa-user-plus text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="text-2xl font-black leading-tight">Verification Required</h4>
                                <p class="text-sm font-medium text-amber-50 mt-3 mb-8">There are {{ $stats['pending_approvals'] }} new suppliers awaiting node authorization.</p>
                                <a href="{{ route('admin.users.index', ['status' => 'pending']) }}" class="inline-flex px-8 py-4 bg-white text-amber-600 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-50 shadow-xl transition-all">Authenticate Now</a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    // Revenue Evolution Chart
    var revOptions = {
        series: [{
            name: 'Volume',
            data: @json($revenueData->pluck('total'))
        }],
        chart: {
            type: 'area',
            height: 400,
            toolbar: { show: false },
            fontFamily: 'Plus Jakarta Sans, sans-serif'
        },
        colors: ['#16a34a'],
        fill: {
            type: 'gradient',
            gradient: { shadeIntensity: 1, opacityFrom: 0.6, opacityTo: 0.1, stops: [0, 90, 100] }
        },
        stroke: { curve: 'smooth', width: 4 },
        xaxis: {
            categories: @json($revenueData->pluck('month')),
            labels: { style: { colors: '#94a3b8', fontWeight: 700, fontSize: '10px' } },
            axisBorder: { show: false }, axisTicks: { show: false }
        },
        yaxis: { labels: { 
            formatter: (v) => '₱' + v.toLocaleString(),
            style: { colors: '#94a3b8', fontWeight: 700, fontSize: '10px' }
        } },
        grid: { borderColor: '#F1F5F9', strokeDashArray: 10 }
    };
    new ApexCharts(document.querySelector("#revenueChart"), revOptions).render();

    // Node Distribution Donut
    var userOptions = {
        series: @json(array_values($userDistribution)),
        labels: @json(array_keys($userDistribution)),
        chart: { type: 'donut', height: 350, fontFamily: 'Plus Jakarta Sans, sans-serif' },
        colors: ['#10b981', '#3b82f6'],
        stroke: { show: false },
        legend: { position: 'bottom', fontWeight: 700, fontSize: '12px' },
        plotOptions: {
            pie: {
                donut: {
                    size: '80%',
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'Total Nodes',
                            formatter: () => '{{ $stats['total_users'] }}'
                        }
                    }
                }
            }
        },
        dataLabels: { enabled: false }
    };
    new ApexCharts(document.querySelector("#userChart"), userOptions).render();
</script>
@endpush
@endsection
