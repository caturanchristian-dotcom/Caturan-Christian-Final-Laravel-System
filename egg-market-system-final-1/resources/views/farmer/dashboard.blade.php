@extends('layouts.main')

@section('title', 'Supply Node Oversight | Performance Terminal')

@section('content')
<div class="animate-in fade-in duration-700 pb-20">
    <!-- Redesigned Header: Matching Admin Style -->
    <div class="bg-white border-b border-slate-100 shadow-sm relative z-20">
        <div class="max-w-7xl mx-auto px-8 py-12">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-8">
                <div class="space-y-2">
                    <div class="flex items-center gap-3">
                        <div class="flex -space-x-2">
                            <div class="w-6 h-6 rounded-full bg-blue-500 border-2 border-white"></div>
                            <div class="w-6 h-6 rounded-full bg-emerald-500 border-2 border-white"></div>
                            <div class="w-6 h-6 rounded-full bg-slate-200 border-2 border-white flex items-center justify-center text-[8px] font-black text-slate-500">Live</div>
                        </div>
                        <span class="text-xs font-black text-slate-400 uppercase tracking-widest">Active Agricultural Node: {{ Auth::user()->farm_name ?? 'Primary Supply' }}</span>
                    </div>
                    <h1 class="text-5xl font-black text-slate-900 tracking-tighter">Performance Terminal</h1>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="bg-slate-900 text-white p-6 rounded-[32px] shadow-2xl flex items-center gap-6 min-w-[280px]">
                        <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-emerald-400">
                            <i class="fas fa-vault text-xl"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest opacity-50">Node Revenue</p>
                            <p class="text-2xl font-black">₱{{ number_format($totalSales, 0) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-8 py-12">
        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            
            <!-- Left Col: Key Operational Metrics -->
            <div class="lg:col-span-2 space-y-10">
                <!-- Bento Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-8 rounded-[40px] border border-slate-100 shadow-sm dashboard-card">
                        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-6"><i class="fas fa-truck-ramp-box"></i></div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Active Pipeline</p>
                        <p class="text-3xl font-black text-slate-900">{{ $activeOrders }}</p>
                    </div>
                    <div class="bg-white p-8 rounded-[40px] border border-slate-100 shadow-sm dashboard-card">
                        <div class="w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center mb-6"><i class="fas fa-layer-group"></i></div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Available Volume</p>
                        <p class="text-3xl font-black text-slate-900">{{ number_format($availableStock) }}</p>
                    </div>
                    <div class="bg-white p-8 rounded-[40px] border border-slate-100 shadow-sm dashboard-card">
                        <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center mb-6"><i class="fas fa-tags"></i></div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Live Listings</p>
                        <p class="text-3xl font-black text-slate-900">{{ \App\Models\Product::where('user_id', Auth::id())->count() }}</p>
                    </div>
                </div>

                <!-- Sales Performance Chart -->
                <div class="bg-white p-10 rounded-[50px] border border-slate-100 shadow-sm">
                    <div class="flex justify-between items-center mb-10">
                        <div>
                            <h3 class="text-2xl font-black text-slate-900 tracking-tight">Market Momentum</h3>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">7-Day revenue projection</p>
                        </div>
                        <span class="px-4 py-2 rounded-2xl bg-slate-50 text-slate-400 text-[10px] font-black uppercase tracking-widest">Node: Online</span>
                    </div>
                    <div id="salesChart" class="min-h-[400px]"></div>
                </div>

                <!-- Fulfillment Table -->
                <div class="bg-white rounded-[50px] border border-slate-100 shadow-sm overflow-hidden">
                    <div class="p-10 border-b border-slate-50 flex justify-between items-center">
                        <h3 class="text-2xl font-black text-slate-900 tracking-tight">Fulfillment Log</h3>
                        <a href="{{ route('farmer.orders.index') }}" class="text-[10px] font-black text-green-600 uppercase tracking-widest hover:underline decoration-2">Full Trade Log</a>
                    </div>
                    <div class="p-0">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                <tr>
                                    <th class="px-10 py-6">Protocol ID</th>
                                    <th class="px-10 py-6">Counterparty</th>
                                    <th class="px-10 py-6 text-right">Settlement</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50 text-sm font-semibold">
                                @forelse($recentOrders as $order)
                                    <tr class="hover:bg-slate-50/40 transition-colors">
                                        <td class="px-10 py-8 text-slate-900 font-black">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                        <td class="px-10 py-8 text-slate-600">{{ $order->user->name }}</td>
                                        <td class="px-10 py-8 text-right font-black text-slate-900 text-lg">₱{{ number_format($order->total_amount, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="p-20 text-center text-slate-300 italic">No trade signals detected.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Col: Environmental & Category Data -->
            <div class="space-y-10">
                <!-- Weather Node Module (Dark) -->
                <div class="bg-slate-900 p-10 rounded-[50px] text-white shadow-2xl shadow-slate-200 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-bl-full"></div>
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-8">
                            <div class="w-16 h-16 bg-white/10 backdrop-blur-xl text-white rounded-3xl flex items-center justify-center">
                                <i id="weather-icon" class="fas fa-satellite-dish text-2xl transition-all duration-500"></i>
                            </div>
                            <div class="text-right">
                                <p id="weather-temp" class="text-4xl font-black">--°C</p>
                                <p id="weather-desc" class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Link Active</p>
                            </div>
                        </div>
                        <h4 class="text-lg font-black tracking-tight mb-2">Environmental Protocol</h4>
                        <p class="weather-impact text-[10px] font-black text-emerald-400 uppercase tracking-widest flex items-center gap-2">
                            <i class="fas fa-shield-check"></i> System Operational
                        </p>
                    </div>
                </div>

                <!-- Stock Allocation Chart -->
                <div class="bg-white p-10 rounded-[50px] border border-slate-100 shadow-sm">
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight mb-8">Inventory Mix</h3>
                    <div id="stockChart" class="min-h-[300px]"></div>
                </div>

                <!-- Intelligence Alert (Low Stock) -->
                @if($lowStock->count() > 0)
                    <div class="p-10 bg-rose-500 rounded-[50px] text-white shadow-2xl shadow-rose-200 animate-in slide-in-from-right duration-500">
                        <div class="flex items-start gap-6">
                            <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center shrink-0">
                                <i class="fas fa-triangle-exclamation text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="text-2xl font-black leading-tight">Stock Warning</h4>
                                <p class="text-sm font-medium text-rose-50 mt-3 mb-8">{{ $lowStock->count() }} produce node{!! $lowStock->count() > 1 ? 's' : '' !!} require volume optimization.</p>
                                <a href="{{ route('farmer.inventory') }}" class="inline-flex px-8 py-4 bg-white text-rose-600 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-50 shadow-xl transition-all">Optimize Node</a>
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
    // Premium Area Chart (Revenue)
    var salesOptions = {
        series: [{
            name: 'Volume',
            data: @json($salesTrend->pluck('total'))
        }],
        chart: { type: 'area', height: 400, toolbar: { show: false }, fontFamily: 'Plus Jakarta Sans, sans-serif' },
        colors: ['#16a34a'],
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.6, opacityTo: 0.1, stops: [0, 90, 100] } },
        stroke: { curve: 'smooth', width: 4 },
        xaxis: {
            categories: @json($salesTrend->pluck('date')),
            labels: { style: { colors: '#94a3b8', fontWeight: 700, fontSize: '10px' } },
            axisBorder: { show: false }, axisTicks: { show: false }
        },
        yaxis: { labels: { 
            formatter: (v) => '₱' + v.toLocaleString(),
            style: { colors: '#94a3b8', fontWeight: 700, fontSize: '10px' }
        } },
        grid: { borderColor: '#F1F5F9', strokeDashArray: 10 }
    };
    new ApexCharts(document.querySelector("#salesChart"), salesOptions).render();

    // Premium Stock Chart
    var stockOptions = {
        series: @json($stockByCategory->pluck('total_stock')),
        labels: @json($stockByCategory->pluck('name')),
        chart: { type: 'donut', height: 350, fontFamily: 'Plus Jakarta Sans, sans-serif' },
        colors: ['#10b981', '#3b82f6', '#8b5cf6'],
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
                            label: 'Total Units',
                            formatter: () => '{{ number_format($availableStock) }}'
                        }
                    }
                }
            }
        },
        dataLabels: { enabled: false }
    };
    new ApexCharts(document.querySelector("#stockChart"), stockOptions).render();

    // GPS Weather Logic
    async function fetchWeather() {
        const lat = parseFloat("{{ Auth::user()->latitude }}") || 14.5995;
        const lon = parseFloat("{{ Auth::user()->longitude }}") || 120.9842;
        try {
            const res = await fetch(`https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current_weather=true`);
            const data = await res.json();
            const weather = data.current_weather;
            document.getElementById('weather-temp').innerText = Math.round(weather.temperature) + '°C';
            
            const descriptions = {
                0: 'Clear Sky',
                1: 'Mainly Clear', 2: 'Partly Cloudy', 3: 'Overcast',
                45: 'Foggy', 48: 'Depositing Rime Fog',
                51: 'Light Drizzle', 53: 'Moderate Drizzle', 55: 'Dense Drizzle',
                56: 'Light Freezing Drizzle', 57: 'Dense Freezing Drizzle',
                61: 'Slight Rain', 63: 'Moderate Rain', 65: 'Heavy Rain',
                66: 'Light Freezing Rain', 67: 'Heavy Freezing Rain',
                71: 'Slight Snowfall', 73: 'Moderate Snowfall', 75: 'Heavy Snowfall',
                77: 'Snow Grains',
                80: 'Slight Rain Showers', 81: 'Moderate Rain Showers', 82: 'Violent Rain Showers',
                85: 'Slight Snow Showers', 86: 'Heavy Snow Showers',
                95: 'Thunderstorm', 96: 'Thunderstorm with Hail', 99: 'Heavy Thunderstorm with Hail'
            };

            const icons = {
                0: 'fas fa-sun text-amber-400',
                1: 'fas fa-cloud-sun text-sky-300',
                2: 'fas fa-cloud-sun text-sky-300',
                3: 'fas fa-cloud text-slate-400',
                45: 'fas fa-smog text-slate-400',
                48: 'fas fa-smog text-slate-400',
                51: 'fas fa-cloud-rain text-blue-400',
                53: 'fas fa-cloud-rain text-blue-400',
                55: 'fas fa-cloud-rain text-blue-400',
                56: 'fas fa-cloud-rain text-blue-400',
                57: 'fas fa-cloud-rain text-blue-400',
                61: 'fas fa-cloud-rain text-blue-400',
                63: 'fas fa-cloud-rain text-blue-400',
                65: 'fas fa-cloud-showers-heavy text-blue-500',
                66: 'fas fa-cloud-rain text-blue-400',
                67: 'fas fa-cloud-showers-heavy text-blue-500',
                71: 'fas fa-snowflake text-sky-100',
                73: 'fas fa-snowflake text-sky-100',
                75: 'fas fa-snowflake text-sky-100',
                77: 'fas fa-snowflake text-sky-100',
                80: 'fas fa-cloud-rain text-blue-400',
                81: 'fas fa-cloud-rain text-blue-400',
                82: 'fas fa-cloud-showers-heavy text-blue-500',
                85: 'fas fa-snowflake text-sky-100',
                86: 'fas fa-snowflake text-sky-100',
                95: 'fas fa-cloud-bolt text-yellow-500',
                96: 'fas fa-cloud-bolt text-yellow-500',
                99: 'fas fa-cloud-bolt text-yellow-500'
            };

            const code = weather.weathercode;
            const desc = descriptions[code] || 'Optimal';
            const iconClass = icons[code] || 'fas fa-satellite-dish text-white';

            document.getElementById('weather-desc').innerText = "Status: " + desc;

            const iconEl = document.getElementById('weather-icon');
            if (iconEl) {
                iconEl.className = `${iconClass} text-2xl transition-all duration-500`;
            }
        } catch (e) {
            document.getElementById('weather-desc').innerText = "Sensor Offline";
        }
    }
    fetchWeather();
</script>
@endpush
@endsection
