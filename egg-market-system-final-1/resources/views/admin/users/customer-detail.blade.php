@extends('layouts.main')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12 animate-in fade-in duration-700">
    <div class="mb-12 flex items-center justify-between">
        <div>
            <a href="{{ route('admin.users.index') }}" class="text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-green-600 flex items-center gap-2 mb-4 transition-colors">
                <i class="fas fa-arrow-left"></i> Back to User Registry
            </a>
            <h1 class="text-4xl font-black text-gray-900">{{ $user->name }}</h1>
            <p class="text-gray-500 font-medium mt-1 text-sm uppercase tracking-widest">Customer Entity: <span class="text-slate-900 font-bold">#{{ $user->id }}</span></p>
        </div>
        <div class="bg-blue-900 text-white px-8 py-4 rounded-[28px] shadow-2xl shadow-blue-200">
            <p class="text-[10px] font-black uppercase tracking-widest mb-1 opacity-60">Total Lifecycle Value</p>
            <p class="text-3xl font-black">₱{{ number_format($totalSpent, 0) }}</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-10">
        <!-- Profile & Location -->
        <div class="lg:col-span-1 space-y-8">
            <div class="bg-white p-10 rounded-[48px] border border-gray-100 shadow-sm">
                <h3 class="text-xl font-black text-gray-900 mb-8 flex items-center gap-3">
                    <i class="fas fa-user-circle text-blue-600"></i> Identity Profile
                </h3>
                <div class="space-y-6">
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Email Node</p>
                        <p class="font-bold text-gray-900">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Delivery Address</p>
                        <p class="font-bold text-gray-900 leading-relaxed">{{ $user->address ?? 'No physical address logged.' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[48px] border border-gray-100 shadow-sm overflow-hidden space-y-4">
                <div class="flex justify-between items-center">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Customer Map</p>
                    @if($user->latitude && $user->longitude)
                        <a href="https://www.google.com/maps/search/?api=1&query={{ $user->latitude }},{{ $user->longitude }}" target="_blank" class="text-[10px] font-black text-blue-600 hover:text-blue-800 uppercase tracking-widest flex items-center gap-1 bg-blue-50 px-3 py-1.5 rounded-full border border-blue-100 transition-colors">
                            <i class="fas fa-map-marker-alt"></i> Open Google Maps
                        </a>
                    @endif
                </div>
                <div id="customerMap" class="h-64 w-full rounded-[38px]"></div>
            </div>
        </div>

        <!-- Trade History -->
        <div class="lg:col-span-2 space-y-10">
            <div class="bg-white rounded-[40px] border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-10 border-b border-gray-50 flex justify-between items-center">
                    <h3 class="text-2xl font-black text-gray-900 tracking-tight">Trade History</h3>
                    <span class="bg-blue-50 px-4 py-1.5 rounded-xl font-black text-[10px] text-blue-700 uppercase tracking-widest">{{ $orders->count() }} Transactions</span>
                </div>
                <div class="p-0">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                            <tr>
                                <th class="px-10 py-6">ID</th>
                                <th class="px-10 py-6">Date</th>
                                <th class="px-10 py-6">Status</th>
                                <th class="px-10 py-6 text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($orders as $order)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-10 py-8 font-black text-slate-900 text-sm">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                    <td class="px-10 py-8 text-xs font-bold text-slate-400 uppercase tracking-widest">{{ $order->created_at->format('M d, Y') }}</td>
                                    <td class="px-10 py-8">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                                            @if($order->status == 'delivered') bg-green-100 text-green-700
                                            @elseif($order->status == 'cancelled') bg-red-100 text-red-700
                                            @else bg-yellow-100 text-yellow-700 @endif
                                        ">{{ $order->status }}</span>
                                    </td>
                                    <td class="px-10 py-8 text-right font-black text-slate-900 text-lg">₱{{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-20 text-center text-slate-400 italic font-medium">No order data available for this customer.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    @if($user->latitude && $user->longitude)
        var cMap = L.map('customerMap').setView([{{ $user->latitude }}, {{ $user->longitude }}], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(cMap);
        L.marker([{{ $user->latitude }}, {{ $user->longitude }}]).addTo(cMap);
    @else
        // Fallback for demo
        var cMap = L.map('customerMap').setView([14.5995, 120.9842], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(cMap);
    @endif
</script>
@endsection
