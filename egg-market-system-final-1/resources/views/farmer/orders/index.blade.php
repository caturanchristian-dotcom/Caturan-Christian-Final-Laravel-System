@extends('layouts.main')

@section('title', 'Trade Fulfillment Engine | EggMarket')

@section('content')
<div class="animate-in fade-in duration-700 pb-20">
    <!-- Sophisticated Header -->
    <div class="bg-white border-b border-slate-100 shadow-sm relative z-20">
        <div class="max-w-7xl mx-auto px-8 py-12">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-8">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></div>
                        <span class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Active Trade Stream</span>
                    </div>
                    <h1 class="text-5xl font-black text-slate-900 tracking-tighter">Fulfillment Engine</h1>
                    <p class="text-slate-400 font-semibold mt-1">Real-time processing of regional supply contracts.</p>
                </div>
                
                <div class="bg-slate-900 text-white p-8 rounded-[40px] shadow-2xl flex items-center gap-8 min-w-[340px]">
                    <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center text-blue-400">
                        <i class="fas fa-truck-fast text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest opacity-50">Pending Shipments</p>
                        <p class="text-4xl font-black">{{ $orders->where('status', '!=', 'delivered')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-8 py-12">
        <!-- Fulfillment Audit Grid -->
        <div class="bg-white rounded-[50px] border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                        <tr>
                            <th class="px-10 py-8">Contract Identification</th>
                            <th class="px-10 py-8">Acquisition Entity</th>
                            <th class="px-10 py-8">Payload Detail</th>
                            <th class="px-10 py-8">Settlement Value</th>
                            <th class="px-10 py-8 text-right">Fulfillment Protocol</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($orders as $order)
                            <tr class="hover:bg-slate-50/40 transition-all group">
                                <td class="px-10 py-10">
                                    <span class="font-black text-slate-900 text-lg">#TRD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">{{ $order->created_at->format('M d, Y') }}</p>
                                </td>
                                <td class="px-10 py-10">
                                    <div>
                                        <p class="font-black text-slate-700 text-sm leading-tight">{{ $order->user->name }}</p>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">{{ Str::limit($order->user->address ?? 'Node Address Required', 25) }}</p>
                                        @if($order->user->latitude)
                                            <button onclick='showCustomerMap(@json($order->user))' class="mt-2 text-[10px] font-black text-blue-600 uppercase tracking-widest flex items-center gap-1 hover:underline">
                                                <i class="fas fa-location-dot"></i> Pin GPS
                                            </button>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-10 py-10">
                                    <div class="space-y-2">
                                        @foreach($order->items as $item)
                                            <div class="flex items-center gap-2">
                                                <div class="w-2 h-2 rounded-full bg-slate-200"></div>
                                                <span class="text-xs font-bold text-slate-500">{{ $item->product->name }} (x{{ $item->quantity }})</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-10 py-10 font-black text-slate-900 text-xl tracking-tighter">
                                    ₱{{ number_format($order->total_amount, 2) }}
                                </td>
                                <td class="px-10 py-10 text-right">
                                    <form action="{{ route('farmer.orders.updateStatus', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="rounded-[20px] border-none font-black text-[10px] uppercase tracking-widest focus:ring-4 focus:ring-opacity-20 cursor-pointer py-3 pl-6 pr-12
                                            {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-700 focus:ring-yellow-500' : '' }}
                                            {{ $order->status == 'processing' ? 'bg-blue-100 text-blue-700 focus:ring-blue-500' : '' }}
                                            {{ $order->status == 'on the way' ? 'bg-purple-100 text-purple-700 focus:ring-purple-500' : '' }}
                                            {{ $order->status == 'delivered' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                        ">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="on the way" {{ $order->status == 'on the way' ? 'selected' : '' }}>On the Way</option>
                                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-40 text-center text-slate-300 italic font-bold">Awaiting initial market demand protocol.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-16">
            {{ $orders->links() }}
        </div>
    </div>
</div>

<!-- Map Modal Logic (Simplified for Redesign) -->
<div id="mapModal" class="hidden fixed inset-0 z-[100] bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-6">
    <div class="bg-white rounded-[50px] w-full max-w-4xl shadow-2xl overflow-hidden animate-in zoom-in-95 duration-200">
        <div class="p-10 border-b flex justify-between items-center bg-white">
            <div class="flex items-center gap-4">
                <h2 id="modalTitle" class="text-3xl font-black text-slate-900 tracking-tighter">Node Tracking</h2>
                <a id="googleMapsLink" href="#" target="_blank" class="text-[10px] font-black text-green-600 hover:text-green-800 uppercase tracking-widest flex items-center gap-1 bg-green-50 px-3 py-2 rounded-xl border border-green-100 transition-colors">
                    <i class="fas fa-map-marker-alt"></i> Open Google Maps
                </a>
            </div>
            <button onclick="document.getElementById('mapModal').classList.add('hidden')" class="w-12 h-12 rounded-2xl bg-slate-50 text-slate-400 hover:text-rose-500 transition-all flex items-center justify-center">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="customerMap" class="h-[500px] w-full bg-slate-100"></div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    var cMap; var cMarker;
    function showCustomerMap(user) {
        document.getElementById('mapModal').classList.remove('hidden');
        document.getElementById('googleMapsLink').href = `https://www.google.com/maps/search/?api=1&query=${user.latitude},${user.longitude}`;
        if (!cMap) {
            cMap = L.map('customerMap').setView([user.latitude, user.longitude], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(cMap);
        } else { cMap.setView([user.latitude, user.longitude], 15); }
        if (cMarker) cMap.removeLayer(cMarker);
        cMarker = L.marker([user.latitude, user.longitude]).addTo(cMap);
        setTimeout(() => { cMap.invalidateSize(); }, 200);
    }
</script>
@endsection
