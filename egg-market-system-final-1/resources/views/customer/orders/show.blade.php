@extends('layouts.main')

@section('title', 'Order Protocol Detail | EggMarket')

@section('content')
<div class="animate-in fade-in duration-700 pb-20">
    <!-- Premium Header -->
    <div class="bg-white border-b border-slate-100 shadow-sm relative z-20">
        <div class="max-w-7xl mx-auto px-8 py-12">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-end gap-10">
                <div class="space-y-4">
                    <a href="{{ route('orders.index') }}" class="inline-flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] hover:text-green-600 transition-colors font-sans">
                        <i class="fas fa-arrow-left"></i> Back to History
                    </a>
                    <div class="flex items-center gap-6">
                        <div class="w-20 h-20 bg-slate-900 rounded-[28px] flex items-center justify-center text-white font-black text-2xl shadow-2xl shadow-slate-200">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <div>
                            <h1 class="text-4xl font-black text-slate-900 tracking-tighter leading-none">Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h1>
                            <div class="flex items-center gap-4 mt-3">
                                @php
                                    $statusColor = 'text-amber-600 bg-amber-50 border-amber-100';
                                    if($order->status == 'processing') $statusColor = 'text-blue-600 bg-blue-50 border-blue-100';
                                    if($order->status == 'on the way') $statusColor = 'text-purple-600 bg-purple-50 border-purple-100';
                                    if($order->status == 'delivered') $statusColor = 'text-emerald-600 bg-emerald-50 border-emerald-100';
                                @endphp
                                <span class="px-4 py-1.5 rounded-xl border {{ $statusColor }} text-[10px] font-black uppercase tracking-widest">{{ $order->status }}</span>
                                <span class="h-1 w-1 rounded-full bg-slate-300"></span>
                                <p class="text-xs font-bold text-slate-400 tracking-tight">Initiated {{ $order->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center gap-6 bg-slate-900 text-white p-6 rounded-[32px] border border-slate-800 min-w-[300px] shadow-2xl shadow-slate-200">
                    <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-green-400"><i class="fas fa-coins"></i></div>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest opacity-50">Settlement Value</p>
                        <p class="text-2xl font-black">₱{{ number_format($order->total_amount, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-8 py-12">
        <div class="grid lg:grid-cols-3 gap-12">
            
            <!-- Items Audit (Left 2/3) -->
            <div class="lg:col-span-2 space-y-10">
                <div class="bg-white rounded-[50px] border border-slate-100 shadow-sm overflow-hidden">
                    <div class="p-10 border-b border-slate-50">
                        <h3 class="text-xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                            <i class="fas fa-shopping-bag text-green-600"></i> Produce Acquisition Detail
                        </h3>
                    </div>
                    <div class="divide-y divide-slate-50">
                        @foreach($order->items as $item)
                            <div class="p-10 flex flex-col md:flex-row md:items-center justify-between gap-8 group">
                                <div class="flex items-center gap-8">
                                    <div class="relative shrink-0">
                                        <img src="{{ $item->product->image }}" class="w-24 h-24 rounded-[32px] object-cover shadow-2xl shadow-slate-200 group-hover:scale-105 transition-transform duration-500" alt="">
                                        <div class="absolute -top-2 -right-2 bg-white w-8 h-8 rounded-full flex items-center justify-center font-black text-xs shadow-lg border border-slate-50 text-slate-900">
                                            x{{ $item->quantity }}
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="text-2xl font-black text-slate-900 leading-tight">{{ $item->product->name }}</h4>
                                        <div class="flex items-center gap-3 mt-1">
                                            <i class="fas fa-tractor text-[10px] text-green-500"></i>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Node: {{ $item->product->user->farm_name ?? $item->product->user->name }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-left md:text-right border-t md:border-t-0 pt-6 md:pt-0 border-slate-50">
                                    <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest mb-1">Price per {{ $item->product->unit }}</p>
                                    <p class="text-2xl font-black text-slate-900 tracking-tighter">₱{{ number_format($item->price, 2) }}</p>
                                </div>
                            </div>

                            @if($order->status == 'delivered')
                                <div class="px-10 pb-10">
                                    <div class="bg-slate-50 rounded-[40px] p-8 border border-slate-100 animate-in zoom-in-95 duration-500">
                                        <h5 class="text-sm font-black text-slate-900 uppercase tracking-[0.2em] mb-6 flex items-center gap-3">
                                            <i class="fas fa-star text-amber-400"></i> Node Feedback Protocol
                                        </h5>
                                        <form action="{{ route('reviews.store', $item->product->id) }}" method="POST" class="space-y-6">
                                            @csrf
                                            <div class="flex gap-4">
                                                @for($i=1; $i<=5; $i++)
                                                    <label class="cursor-pointer group/star">
                                                        <input type="radio" name="rating" value="{{ $i }}" class="hidden peer" required>
                                                        <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-slate-200 border-2 border-transparent peer-checked:bg-amber-400 peer-checked:text-white transition-all group-hover/star:scale-110 shadow-sm">
                                                            <i class="fas fa-star"></i>
                                                        </div>
                                                    </label>
                                                @endfor
                                            </div>
                                            <textarea name="comment" rows="3" required class="w-full bg-white border-none rounded-3xl p-6 font-medium text-sm focus:ring-4 focus:ring-green-500/10 shadow-sm" placeholder="Analyze produce quality and node reliability..."></textarea>
                                            <button type="submit" class="bg-slate-900 text-white px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-black transition-all shadow-xl shadow-slate-200">Deploy Feedback</button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Fulfillment Sidebar (Right 1/3) -->
            <div class="lg:col-span-1 space-y-10">
                <!-- Logistics Module -->
                <div class="bg-white p-10 rounded-[50px] border border-slate-100 shadow-sm">
                    <h3 class="text-xl font-black text-slate-900 mb-10 flex items-center gap-3">
                        <i class="fas fa-truck-fast text-blue-600"></i> Logistics Tracking
                    </h3>
                    <div class="space-y-10 relative">
                        <!-- Vertical Line -->
                        <div class="absolute left-[19px] top-2 bottom-2 w-0.5 bg-slate-100"></div>

                        <!-- Step 1 -->
                        <div class="flex gap-6 relative z-10">
                            <div class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center text-xs shadow-lg shadow-green-100 border-4 border-white">
                                <i class="fas fa-check"></i>
                            </div>
                            <div>
                                <p class="text-sm font-black text-slate-900">Protocol Initiated</p>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">{{ $order->created_at->format('M d, h:i A') }}</p>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        @php $isProcessing = in_array($order->status, ['processing', 'on the way', 'delivered']); @endphp
                        <div class="flex gap-6 relative z-10 opacity-{{ $isProcessing ? '100' : '30' }}">
                            <div class="w-10 h-10 rounded-full {{ $isProcessing ? 'bg-blue-500' : 'bg-slate-200' }} text-white flex items-center justify-center text-xs border-4 border-white">
                                <i class="fas fa-microchip"></i>
                            </div>
                            <div>
                                <p class="text-sm font-black text-slate-900">Processing Node</p>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">{{ $isProcessing ? 'Active' : 'Awaiting Cycle' }}</p>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        @php $isOnWay = in_array($order->status, ['on the way', 'delivered']); @endphp
                        <div class="flex gap-6 relative z-10 opacity-{{ $isOnWay ? '100' : '30' }}">
                            <div class="w-10 h-10 rounded-full {{ $isOnWay ? 'bg-purple-500' : 'bg-slate-200' }} text-white flex items-center justify-center text-xs border-4 border-white">
                                <i class="fas fa-shipping-fast"></i>
                            </div>
                            <div>
                                <p class="text-sm font-black text-slate-900">Transit Terminal</p>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">{{ $isOnWay ? 'Package in Motion' : 'Awaiting Dispatch' }}</p>
                            </div>
                        </div>

                        <!-- Step 4 -->
                        @php $isDelivered = $order->status == 'delivered'; @endphp
                        <div class="flex gap-6 relative z-10 opacity-{{ $isDelivered ? '100' : '30' }}">
                            <div class="w-10 h-10 rounded-full {{ $isDelivered ? 'bg-emerald-500' : 'bg-slate-200' }} text-white flex items-center justify-center text-xs border-4 border-white">
                                <i class="fas fa-home-alt"></i>
                            </div>
                            <div>
                                <p class="text-sm font-black text-slate-900">Final Fulfillment</p>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">{{ $isDelivered ? 'Node Reached' : 'Pending Hub Arrival' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Module -->
                <div class="bg-white p-10 rounded-[50px] border border-slate-100 shadow-sm">
                    <h3 class="text-xl font-black text-slate-900 mb-8 flex items-center gap-3">
                        <i class="fas fa-shield-halved text-emerald-600"></i> Payment Node
                    </h3>
                    <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Settlement Method</p>
                        <div class="flex items-center justify-between">
                            <span class="font-black text-slate-900">Cash on Delivery</span>
                            <i class="fas fa-hand-holding-dollar text-green-600"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
