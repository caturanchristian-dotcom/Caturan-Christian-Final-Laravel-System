@extends('layouts.main')

@section('title', 'Procurement Batch | EggMarket')

@section('content')
<div class="animate-in fade-in duration-700 pb-20">
    <!-- Premium Header -->
    <div class="bg-white border-b border-slate-100 shadow-sm relative z-20">
        <div class="max-w-7xl mx-auto px-8 py-12">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-8">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                        <span class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Active Procurement Session</span>
                    </div>
                    <h1 class="text-5xl font-black text-slate-900 tracking-tighter">Shopping Cart</h1>
                    <p class="text-slate-400 font-semibold mt-1">Reviewing node acquisition batch.</p>
                </div>
                
                <a href="{{ route('marketplace') }}" class="group px-8 py-4 bg-white border-2 border-slate-100 text-slate-900 rounded-[22px] font-black text-xs uppercase tracking-widest hover:bg-slate-50 transition-all flex items-center gap-3">
                    <i class="fas fa-arrow-left text-slate-300 group-hover:-translate-x-1 transition-transform"></i> Continue Shopping
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-8 py-12">
        @if(session('cart') && count(session('cart')) > 0)
            <div class="grid lg:grid-cols-3 gap-12">
                <!-- Batch Items (Left 2/3) -->
                <div class="lg:col-span-2 space-y-6">
                    @foreach(session('cart') as $id => $details)
                        <div class="bg-white p-8 rounded-[48px] border border-slate-100 flex flex-col md:flex-row items-center gap-8 shadow-sm hover:shadow-xl transition-all group">
                            <div class="relative shrink-0">
                                <img src="{{ $details['image'] }}" class="w-32 h-32 rounded-[32px] object-cover shadow-2xl shadow-slate-200 group-hover:scale-105 transition-transform duration-500" alt="">
                                <div class="absolute -top-2 -right-2 w-8 h-8 bg-slate-900 text-white rounded-full flex items-center justify-center font-black text-xs border-4 border-white shadow-lg">
                                    {{ $details['quantity'] }}
                                </div>
                            </div>
                            
                            <div class="flex-1 text-center md:text-left">
                                <h4 class="text-2xl font-black text-slate-900 leading-tight mb-2">{{ $details['name'] }}</h4>
                                <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Protocol Value: ₱{{ number_format($details['price'], 2) }} per {{ $details['unit'] }}</p>
                            </div>

                            <div class="flex items-center gap-6">
                                <div class="bg-slate-50 rounded-2xl p-1 flex items-center border border-slate-100">
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center">
                                        @csrf
                                        <button type="submit" name="quantity" value="{{ $details['quantity'] - 1 }}" class="w-10 h-10 flex items-center justify-center rounded-xl text-slate-400 hover:bg-white hover:text-slate-900 transition-all"><i class="fas fa-minus text-xs"></i></button>
                                        <span class="w-12 text-center font-black text-slate-900">{{ $details['quantity'] }}</span>
                                        <button type="submit" name="quantity" value="{{ $details['quantity'] + 1 }}" class="w-10 h-10 flex items-center justify-center rounded-xl text-slate-400 hover:bg-white hover:text-slate-900 transition-all"><i class="fas fa-plus text-xs"></i></button>
                                    </form>
                                </div>
                                <div class="text-right min-w-[120px]">
                                    <p class="text-2xl font-black text-slate-900 tracking-tighter">₱{{ number_format($details['price'] * $details['quantity'], 2) }}</p>
                                </div>
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    <button class="w-12 h-12 flex items-center justify-center rounded-2xl bg-rose-50 text-rose-400 hover:bg-rose-500 hover:text-white transition-all shadow-sm group/trash">
                                        <i class="fas fa-trash-can text-sm group-hover/trash:rotate-12 transition-transform"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Settlement Sidebar (Right 1/3) -->
                <div class="lg:col-span-1">
                    <div class="bg-white p-10 rounded-[50px] border border-slate-100 shadow-sm sticky top-32">
                        <h3 class="text-2xl font-black text-slate-900 tracking-tight mb-8">Settlement Detail</h3>
                        
                        <div class="space-y-6 mb-10 pb-8 border-b border-slate-50">
                            <div class="flex justify-between items-center text-sm font-bold text-slate-400">
                                <span class="uppercase tracking-widest">Protocol Subtotal</span>
                                <span class="text-slate-900">₱{{ number_format($total, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm font-bold text-slate-400">
                                <span class="uppercase tracking-widest">Node Logistics</span>
                                <span class="text-emerald-500 font-black">Calculated</span>
                            </div>
                            <div class="flex justify-between items-center pt-6">
                                <span class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em]">Grand Total</span>
                                <span class="text-4xl font-black text-slate-900 tracking-tighter">₱{{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <div class="bg-slate-900 rounded-[32px] p-8 text-white mb-10 shadow-2xl shadow-slate-200 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-24 h-24 bg-white/5 rounded-bl-full"></div>
                            <div class="relative z-10">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Final Fulfillment Protocol</p>
                                <form action="{{ route('orders.store') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full bg-green-500 text-white py-5 rounded-[22px] font-black text-lg hover:bg-green-400 transition-all hover:scale-105 active:scale-95 shadow-xl shadow-green-900/20 mb-4">
                                        Initiate Order (COD)
                                    </button>
                                </form>
                                <div class="flex items-center justify-center gap-3 text-slate-500">
                                    <i class="fas fa-shield-halved text-[10px]"></i>
                                    <p class="text-[8px] font-black uppercase tracking-widest">Secured Exchange Pipeline</p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                <i class="fas fa-truck-fast text-green-600"></i>
                                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest leading-snug">GPS Tracking Active for Fulfillment</span>
                            </div>
                            <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                <i class="fas fa-certificate text-blue-600"></i>
                                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest leading-snug">Verified Producer Nodes Only</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-40 bg-white rounded-[60px] border border-slate-100 animate-in zoom-in-95 duration-700">
                <div class="w-24 h-24 bg-slate-50 text-slate-200 rounded-[40px] flex items-center justify-center mx-auto mb-8 shadow-inner">
                    <i class="fas fa-shopping-basket text-4xl"></i>
                </div>
                <h2 class="text-3xl font-black text-slate-900 mb-4">Batch Queue Empty</h2>
                <p class="text-slate-400 font-medium max-w-sm mx-auto mb-10 leading-relaxed">Your procurement protocol requires at least one active node listing to proceed.</p>
                <a href="{{ route('marketplace') }}" class="inline-flex px-10 py-4 bg-slate-900 text-white rounded-[20px] font-black text-xs uppercase tracking-[0.2em] hover:bg-black transition-all hover:scale-110 active:scale-95 shadow-2xl shadow-slate-100">
                    Access Global Market
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
