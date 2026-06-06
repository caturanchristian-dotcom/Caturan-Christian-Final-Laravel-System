@extends('layouts.main')

@section('title', 'Customer Terminal | EggMarket')

@section('content')
<div class="py-12 px-6 lg:px-8 max-w-7xl mx-auto space-y-12">
    
    <!-- Top Greeting Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 bg-white p-8 md:p-12 rounded-[50px] border border-slate-100 shadow-sm relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-full bg-slate-50/50 rounded-l-full -z-0"></div>
        <div class="relative z-10 space-y-2">
            <span class="px-4 py-2 rounded-2xl bg-green-50 text-green-600 text-[10px] font-black uppercase tracking-widest flex items-center gap-2 w-fit">
                <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                Node Connected
            </span>
            <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter">Welcome back, <span class="text-slate-700">{{ Auth::user()->name }}</span>!</h1>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Global Customer Node : #USR-{{ str_pad(Auth::id(), 5, '0', STR_PAD_LEFT) }}</p>
        </div>
        
        <div class="flex items-center gap-4 relative z-10 shrink-0">
            <a href="{{ route('marketplace') }}" class="px-8 py-4 bg-green-600 hover:bg-green-700 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl shadow-green-150 transition-all hover:-translate-y-0.5 active:scale-95">
                <i class="fas fa-store mr-2"></i> Shop Market
            </a>
            <a href="{{ route('cart.index') }}" class="px-8 py-4 bg-slate-100 hover:bg-slate-200 text-slate-800 rounded-2xl font-black text-xs uppercase tracking-widest transition-all active:scale-95">
                <i class="fas fa-shopping-basket mr-2"></i> View Basket
            </a>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        
        <!-- Total Spent -->
        <div class="bg-white p-8 rounded-[40px] border border-slate-100 shadow-sm flex items-center gap-6 group hover:border-green-200 transition-all duration-300">
            <div class="w-16 h-16 rounded-3xl bg-green-500/10 text-green-600 flex items-center justify-center text-2xl shrink-0 group-hover:scale-110 transition-transform">
                <i class="fas fa-receipt"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-2">Total Investments</p>
                <p class="text-2xl font-black text-slate-900">₱{{ number_format($totalSpent, 2) }}</p>
            </div>
        </div>

        <!-- Active Orders -->
        <div class="bg-white p-8 rounded-[40px] border border-slate-100 shadow-sm flex items-center gap-6 group hover:border-blue-250 transition-all duration-300">
            <div class="w-16 h-16 rounded-3xl bg-blue-500/10 text-blue-600 flex items-center justify-center text-2xl shrink-0 group-hover:scale-110 transition-transform">
                <i class="fas fa-truck-ramp-box"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-2">In-Transit Parcels</p>
                <p class="text-2xl font-black text-slate-900">{{ $activeOrdersCount }}</p>
            </div>
        </div>

        <!-- Completed Shipments -->
        <div class="bg-white p-8 rounded-[40px] border border-slate-100 shadow-sm flex items-center gap-6 group hover:border-emerald-200 transition-all duration-300">
            <div class="w-16 h-16 rounded-3xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center text-2xl shrink-0 group-hover:scale-110 transition-transform">
                <i class="fas fa-box-open"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-2">Completed Nodes</p>
                <p class="text-2xl font-black text-slate-900">{{ $completedOrdersCount }}</p>
            </div>
        </div>

        <!-- GPS Deliver Node -->
        <div class="bg-white p-8 rounded-[40px] border border-slate-100 shadow-sm flex items-center gap-6 group hover:border-teal-200 transition-all duration-300">
            <div class="w-16 h-16 rounded-3xl bg-teal-500/10 text-teal-600 flex items-center justify-center text-2xl shrink-0 group-hover:scale-110 transition-transform">
                <i class="fas fa-location-dot"></i>
            </div>
            <div class="overflow-hidden">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-2">My Pinned Coordinate</p>
                <p class="text-sm font-black text-slate-900 truncate">{{ Auth::user()->latitude ?? '14.5995' }}, {{ Auth::user()->longitude ?? '120.9842' }}</p>
            </div>
        </div>

    </div>

    <!-- Core Layout Section: Charts, Maps and Logs -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        <!-- Left Side (Main Analytics & Order Log) -->
        <div class="lg:col-span-2 space-y-10">
            
            <!-- Financial Trend Chart -->
            <div class="bg-white p-10 rounded-[50px] border border-slate-100 shadow-sm">
                <div class="flex justify-between items-center mb-10">
                    <div>
                        <h3 class="text-2xl font-black text-slate-900 tracking-tight">Investment Footprint</h3>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">30-Day aggregate capital distribution</p>
                    </div>
                    <span class="px-4 py-2 rounded-2xl bg-slate-50 text-slate-400 text-[10px] font-black uppercase tracking-widest">Active Sync</span>
                </div>
                <div id="spendChart" class="min-h-[400px]"></div>
            </div>

            <!-- Fulfillment Log (Recent Orders) -->
            <div class="bg-white rounded-[50px] border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-10 border-b border-slate-50 flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-black text-slate-900 tracking-tight">Fulfillment History</h3>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Status of your trades</p>
                    </div>
                    <a href="{{ route('orders.index') }}" class="text-[10px] font-black text-green-600 uppercase tracking-widest hover:underline decoration-2">Full History Log</a>
                </div>
                <div class="p-0 overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[600px]">
                        <thead class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                            <tr>
                                <th class="px-10 py-6">Order Code</th>
                                <th class="px-10 py-6">Date Placed</th>
                                <th class="px-10 py-6">State Protocol</th>
                                <th class="px-10 py-6 text-right font-black">Settlement</th>
                                <th class="px-10 py-6 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 text-sm font-semibold">
                            @forelse($recentOrders as $order)
                                <tr class="hover:bg-slate-50/40 transition-all duration-150">
                                    <td class="px-10 py-8 text-slate-950 font-black">
                                        #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-10 py-8 text-slate-500 font-bold">
                                        {{ $order->created_at->format('M d, Y h:i A') }}
                                    </td>
                                    <td class="px-10 py-8">
                                        @if($order->status == 'pending')
                                            <span class="px-3.5 py-1.5 rounded-full bg-amber-500/10 text-amber-600 text-[10px] font-black uppercase tracking-wider">Pending Release</span>
                                        @elseif($order->status == 'processing')
                                            <span class="px-3.5 py-1.5 rounded-full bg-blue-500/10 text-blue-600 text-[10px] font-black uppercase tracking-wider">Staging Node</span>
                                        @elseif($order->status == 'shipped')
                                            <span class="px-3.5 py-1.5 rounded-full bg-purple-500/10 text-purple-600 text-[10px] font-black uppercase tracking-wider">In-Transit</span>
                                        @elseif($order->status == 'delivered')
                                            <span class="px-3.5 py-1.5 rounded-full bg-emerald-500/10 text-emerald-600 text-[10px] font-black uppercase tracking-wider">Arrived</span>
                                        @else
                                            <span class="px-3.5 py-1.5 rounded-full bg-slate-100 text-slate-500 text-[10px] font-black uppercase tracking-wider">Cancelled</span>
                                        @endif
                                    </td>
                                    <td class="px-10 py-8 text-right font-black text-slate-900 text-base">
                                        ₱{{ number_format($order->total_amount, 2) }}
                                    </td>
                                    <td class="px-10 py-8 text-right">
                                        <a href="{{ route('orders.show', $order->id) }}" class="inline-flex px-5 py-2.5 bg-slate-50 border border-slate-100 text-slate-700 hover:bg-slate-100 hover:text-slate-900 rounded-xl font-bold text-xs transition-colors">
                                            Telemetry
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-20 text-center text-slate-300 italic">No trade transactions captured on your profile.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Right Side Blocks (Donut Mix & Live Delivery Map) -->
        <div class="space-y-10">
            
            <!-- Category Dist Donut -->
            <div class="bg-white p-10 rounded-[50px] border border-slate-100 shadow-sm">
                <h3 class="text-2xl font-black text-slate-900 tracking-tight mb-8">Purchase Allocation</h3>
                <div id="allocationChart" class="min-h-[300px]"></div>
            </div>

            <!-- Leaflet Interactive Map showing Delivery Node -->
            <div class="bg-white p-10 rounded-[50px] border border-slate-100 shadow-sm space-y-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-black text-slate-900 tracking-tight">Delivery Pin</h3>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Geospatial delivery node</p>
                    </div>
                    <a id="dashboardGoogleMapsLink" href="https://www.google.com/maps/search/?api=1&query={{ Auth::user()->latitude ?? 14.5995 }},{{ Auth::user()->longitude ?? 120.9842 }}" target="_blank" class="px-3 py-1.5 rounded-full bg-blue-50 hover:bg-blue-100 border border-blue-100 text-blue-600 text-[10px] font-black uppercase tracking-widest transition-colors">
                        <i class="fas fa-map-marked-alt"></i> External
                    </a>
                </div>

                <div id="customerDashboardMap" class="h-64 w-full rounded-[30px] border-2 border-slate-50 overflow-hidden relative z-10 shadow-inner"></div>

                <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Standard Shipping Node</p>
                    <p class="text-sm font-bold text-slate-800 leading-relaxed">{{ Auth::user()->address ?? 'No Address registered' }}</p>
                    <a href="{{ route('profile.settings') }}" class="inline-flex mt-4 text-[10px] font-black text-green-600 uppercase tracking-widest hover:underline gap-1">
                        <i class="fas fa-gear"></i> Update Coordinates
                    </a>
                </div>
            </div>

        </div>

    </div>

</div>

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        // --- APEXCHARTS SPEND AREA CHART ---
        const spendData = @json($spendTrend->pluck('total'));
        const spendDates = @json($spendTrend->pluck('date'));
        
        const spendOptions = {
            series: [{
                name: 'Capital Allocation',
                data: spendData.length ? spendData : [0]
            }],
            chart: { 
                type: 'area', 
                height: 400, 
                toolbar: { show: false }, 
                fontFamily: 'Plus Jakarta Sans, sans-serif' 
            },
            colors: ['#0f766e'],
            fill: { 
                type: 'gradient', 
                gradient: { 
                    shadeIntensity: 1, 
                    opacityFrom: 0.6, 
                    opacityTo: 0.1, 
                    stops: [0, 90, 100] 
                } 
            },
            stroke: { curve: 'smooth', width: 4 },
            xaxis: {
                categories: spendDates.length ? spendDates : ['No Trades'],
                labels: { style: { colors: '#94a3b8', fontWeight: 700, fontSize: '10px' } },
                axisBorder: { show: false }, 
                axisTicks: { show: false }
            },
            yaxis: { 
                labels: { 
                    formatter: (v) => '₱' + v.toLocaleString(),
                    style: { colors: '#94a3b8', fontWeight: 700, fontSize: '10px' }
                } 
            },
            grid: { borderColor: '#F1F5F9', strokeDashArray: 10 },
            noData: {
                text: 'Accumulate purchases to analyze trends.',
                align: 'center',
                verticalAlign: 'middle',
                style: {
                    color: '#94a3b8',
                    fontSize: '14px',
                    fontFamily: 'Plus Jakarta Sans, sans-serif'
                }
            }
        };
        new ApexCharts(document.querySelector("#spendChart"), spendOptions).render();

        // --- APEXCHARTS CATEGORY DONUT CHART ---
        const catDistribution = @json($categoryDistribution);
        const catValues = catDistribution.map(item => parseFloat(item.total_spend)) || [];
        const catLabels = catDistribution.map(item => item.name) || [];

        const donutOptions = {
            series: catValues.length ? catValues : [1],
            labels: catLabels.length ? catLabels : ['Empty Allocation'],
            chart: { 
                type: 'donut', 
                height: 350, 
                fontFamily: 'Plus Jakarta Sans, sans-serif' 
            },
            colors: catValues.length ? ['#0f766e', '#3b82f6', '#8b5cf6', '#10b981', '#f59e0b'] : ['#e2e8f0'],
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
                                label: 'Total Placed',
                                formatter: () => '₱{{ number_format($totalSpent) }}'
                            }
                        }
                    }
                }
            },
            dataLabels: { enabled: false },
            noData: {
                text: 'No category signals detected.',
                align: 'center',
                verticalAlign: 'middle',
                style: {
                    color: '#94a3b8',
                    fontSize: '14px',
                    fontFamily: 'Plus Jakarta Sans, sans-serif'
                }
            }
        };
        new ApexCharts(document.querySelector("#allocationChart"), donutOptions).render();

        // --- INTERACTIVE LEAFLET DELIVERY MAP ---
        const userLat = parseFloat("{{ Auth::user()->latitude }}") || 14.5995;
        const userLng = parseFloat("{{ Auth::user()->longitude }}") || 120.9842;
        
        try {
            const deliveryMap = L.map('customerDashboardMap', {
                scrollWheelZoom: false
            }).setView([userLat, userLng], 14);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(deliveryMap);
            
            // Custom high contrast marker
            const marker = L.marker([userLat, userLng]).addTo(deliveryMap);
            marker.bindPopup("<div class='font-bold text-slate-800 text-xs text-center'><i class='fas fa-house-chimney text-green-600 mr-1'></i>My Pinned Node<br>GPS Active</div>").openPopup();
        } catch(e) {
            console.error("Leaflet mapping subsystem inactive:", e);
        }
        
    });
</script>
@endpush
@endsection
