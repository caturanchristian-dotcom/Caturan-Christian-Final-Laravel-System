@extends('layouts.main')

@section('title', 'Producer Intelligence Node | Command Center')

@section('content')
<div class="animate-in fade-in duration-700 pb-20">
    <!-- Premium Header -->
    <div class="bg-white border-b border-slate-100 shadow-sm relative z-20">
        <div class="max-w-7xl mx-auto px-8 py-12">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-end gap-10">
                <div class="space-y-4">
                    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] hover:text-green-600 transition-colors">
                        <i class="fas fa-arrow-left"></i> Back to Node Registry
                    </a>
                    <div class="flex items-center gap-6">
                        <div class="w-24 h-24 bg-slate-900 rounded-[32px] flex items-center justify-center text-white font-black text-4xl shadow-2xl shadow-slate-200">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <h1 class="text-5xl font-black text-slate-900 tracking-tighter">{{ $user->farm_name ?? $user->name }}</h1>
                            <div class="flex items-center gap-4 mt-2">
                                <span class="px-4 py-1.5 rounded-xl bg-green-50 text-green-700 text-[10px] font-black uppercase tracking-widest border border-green-100">Verified Producer Node</span>
                                <span class="h-1 w-1 rounded-full bg-slate-300"></span>
                                <p class="text-sm font-bold text-slate-400 tracking-tight">System ID: #SUP-{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center gap-6 bg-slate-50 p-6 rounded-[32px] border border-slate-100 min-w-[320px]">
                    <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-green-600 shadow-sm"><i class="fas fa-chart-network fa-lg"></i></div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Delivered Revenue</p>
                        <p class="text-3xl font-black text-slate-900">₱{{ number_format($orders->where('status', 'delivered')->sum('total_amount'), 0) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-8 py-12">
        <div class="grid lg:grid-cols-3 gap-12">
            
            <!-- Side Col: Identity & Geospatial -->
            <div class="lg:col-span-1 space-y-10">
                <!-- Identity Module -->
                <div class="bg-white p-10 rounded-[50px] border border-slate-100 shadow-sm">
                    <h3 class="text-xl font-black text-slate-900 mb-10 flex items-center gap-3">
                        <i class="fas fa-fingerprint text-green-600"></i> Entity Profile
                    </h3>
                    <div class="space-y-8">
                        <div>
                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest mb-2">Legal Administrator</p>
                            <p class="text-lg font-black text-slate-900">{{ $user->name }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest mb-2">Data Endpoint</p>
                            <p class="text-lg font-black text-slate-900 truncate hover:text-green-600 transition-colors">{{ $user->email }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest mb-2">Physical Coordinates</p>
                            <p class="text-sm font-bold text-slate-500 leading-relaxed">{{ $user->address ?? 'Geospatial link required.' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Geospatial Module -->
                <div class="bg-white p-6 rounded-[50px] border border-slate-100 shadow-sm overflow-hidden group space-y-4">
                    <div class="flex justify-between items-center">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Producer Node Map</p>
                        @if($user->latitude && $user->longitude)
                            <a href="https://www.google.com/maps/search/?api=1&query={{ $user->latitude }},{{ $user->longitude }}" target="_blank" class="text-[10px] font-black text-green-600 hover:text-green-800 uppercase tracking-widest flex items-center gap-1 bg-green-50 px-3 py-1.5 rounded-full border border-green-100 transition-colors">
                                <i class="fas fa-map-marker-alt"></i> Open Google Maps
                            </a>
                        @endif
                    </div>
                    <div id="supplierMap" class="h-80 w-full rounded-[40px] group-hover:grayscale-0 grayscale-[0.5] transition-all duration-700"></div>
                </div>
            </div>

            <!-- Main Col: Inventory & Traceability -->
            <div class="lg:col-span-2 space-y-12">
                
                <!-- Live Inventory Listings -->
                <div class="bg-white rounded-[50px] border border-slate-100 shadow-sm overflow-hidden">
                    <div class="p-10 border-b border-slate-50 flex justify-between items-center">
                        <h3 class="text-2xl font-black text-slate-900 tracking-tight">Market Offerings</h3>
                        <span class="px-5 py-2 rounded-2xl bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest">{{ $products->count() }} Active Listings</span>
                    </div>
                    <div class="divide-y divide-slate-50">
                        @forelse($products as $product)
                            <div class="p-10 flex items-center justify-between hover:bg-slate-50 transition-all group">
                                <div class="flex items-center gap-8">
                                    <img src="{{ $product->image }}" class="w-20 h-20 rounded-[28px] object-cover shadow-2xl shadow-slate-200 group-hover:scale-110 transition-transform duration-500" alt="">
                                    <div>
                                        <h4 class="text-xl font-black text-slate-900">{{ $product->name }}</h4>
                                        <div class="flex items-center gap-3 mt-1">
                                            <span class="text-[10px] font-black text-green-600 uppercase tracking-widest">{{ $product->category->name }} Tier</span>
                                            <span class="h-1 w-1 rounded-full bg-slate-200"></span>
                                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $product->stock }} {{ $product->unit }}s remaining</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest mb-1">List Price</p>
                                    <p class="text-3xl font-black text-slate-900 tracking-tighter">₱{{ number_format($product->price, 2) }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="p-32 text-center">
                                <p class="text-slate-300 font-bold italic">This producer has zero active listings.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Comprehensive Trade Log -->
                <div class="bg-white rounded-[50px] border border-slate-100 shadow-sm overflow-hidden">
                    <div class="p-10 border-b border-slate-50 flex justify-between items-center bg-slate-900 text-white">
                        <h3 class="text-2xl font-black tracking-tight">Trade Fulfillment Log</h3>
                        <i class="fas fa-barcode opacity-30"></i>
                    </div>
                    <div class="p-0">
                        <table class="w-full text-left">
                            <thead class="bg-slate-800 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">
                                <tr>
                                    <th class="px-10 py-6">ID</th>
                                    <th class="px-10 py-6">Counterparty</th>
                                    <th class="px-10 py-6">State</th>
                                    <th class="px-10 py-6 text-right">Settlement</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50 text-sm font-semibold">
                                @forelse($orders as $order)
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-10 py-8 text-slate-900 font-black">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                        <td class="px-10 py-8 text-slate-500">{{ $order->user->name }}</td>
                                        <td class="px-10 py-8">
                                            <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest shadow-sm
                                                {{ $order->status == 'delivered' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td class="px-10 py-8 text-right font-black text-slate-900 text-lg">₱{{ number_format($order->total_amount, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="p-20 text-center text-slate-300 italic">No trade history recorded for this node.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    @if($user->latitude && $user->longitude)
        var sMap = L.map('supplierMap').setView([{{ $user->latitude }}, {{ $user->longitude }}], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(sMap);
        
        // Premium marker style (Circle indicating the farm node radius)
        L.circle([{{ $user->latitude }}, {{ $user->longitude }}], {
            color: '#16a34a',
            fillColor: '#16a34a',
            fillOpacity: 0.2,
            radius: 300
        }).addTo(sMap);
        
        L.marker([{{ $user->latitude }}, {{ $user->longitude }}]).addTo(sMap);
    @else
        var sMap = L.map('supplierMap').setView([14.5995, 120.9842], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(sMap);
    @endif
</script>
@endsection
