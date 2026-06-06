@extends('layouts.main')

@section('content')
<div class="bg-white border-b border-slate-100/80 shadow-sm relative z-20">
    <div class="max-w-7xl mx-auto px-8 py-10">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-8">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Active Exchange</h1>
                <p class="text-slate-400 font-semibold mt-2 text-sm">Real-time listings from verified regional producers.</p>
            </div>
            
            <form action="{{ route('marketplace') }}" method="GET" class="w-full lg:w-auto flex flex-col sm:flex-row gap-4">
                <div class="relative flex-1 sm:w-80">
                    <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Search eggs or farm nodes..." 
                        value="{{ request('search') }}"
                        class="w-full pl-12 pr-6 py-4 rounded-2xl border-slate-100 bg-slate-50 focus:bg-white focus:ring-4 focus:ring-green-500/10 focus:border-green-500 transition-all font-bold text-sm shadow-inner"
                    >
                </div>
                <div class="flex gap-4">
                    <select name="category" class="rounded-2xl border-slate-100 bg-slate-50 focus:ring-4 focus:ring-green-500/10 focus:border-green-500 font-bold text-sm text-slate-600 px-6 py-4 shadow-inner">
                        <option value="All">All Tiers</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-slate-900 text-white px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-black shadow-2xl shadow-slate-200 transition-all active:scale-95">
                        Optimize
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-8 py-20">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">
        @forelse($products as $product)
            <div class="group bg-white rounded-[48px] border border-slate-100 overflow-hidden hover:shadow-[0_40px_100px_-20px_rgba(0,0,0,0.1)] transition-all duration-500 flex flex-col">
                <a href="{{ route('products.show', $product->id) }}" class="block overflow-hidden relative aspect-[1/1.2]">
                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    @php
                        $catName = strtolower($product->category->name ?? $product->category);
                        $catClass = 'bg-white/90 text-slate-900';
                        if (str_contains($catName, 'chicken')) $catClass = 'bg-orange-500 text-white';
                        elseif (str_contains($catName, 'duck')) $catClass = 'bg-blue-600 text-white';
                        elseif (str_contains($catName, 'organic')) $catClass = 'bg-emerald-500 text-white';
                    @endphp
                    <span class="absolute top-6 left-6 backdrop-blur-md px-4 py-2 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-xl {{ $catClass }}">
                        {{ $product->category->name ?? $product->category }}
                    </span>
                </a>
                <div class="p-10 flex-1 flex flex-col">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 group-hover:text-green-600 transition-colors">
                            <i class="fas fa-tractor text-xs"></i>
                        </div>
                        <p class="text-xs text-slate-400 font-bold tracking-tight">{{ $product->user->farmName ?? $product->user->name }}</p>
                    </div>
                    <a href="{{ route('products.show', $product->id) }}">
                        <h3 class="text-2xl font-black text-slate-900 mb-3 leading-tight group-hover:text-green-600 transition-colors">{{ $product->name }}</h3>
                    </a>
                    <div class="mt-auto pt-8 flex justify-between items-end border-t border-slate-50">
                        <div>
                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest mb-1">Market Price</p>
                            <div class="flex items-baseline">
                                <span class="text-3xl font-black text-slate-900">₱{{ number_format($product->price, 0) }}</span>
                                <span class="text-sm font-black text-slate-400 ml-1">/ {{ $product->unit ?? 'Tray' }}</span>
                            </div>
                        </div>
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button class="bg-green-600 text-white w-16 h-16 rounded-[24px] flex items-center justify-center hover:bg-green-700 shadow-2xl shadow-green-200 transition-all hover:scale-110 active:scale-95">
                                <i class="fas fa-shopping-basket text-xl"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-40 bg-white rounded-[60px] border border-slate-100">
                <div class="w-24 h-24 bg-slate-50 text-slate-200 rounded-[40px] flex items-center justify-center mx-auto mb-8">
                    <i class="fas fa-egg text-4xl"></i>
                </div>
                <h3 class="text-3xl font-black text-slate-900 mb-4">No Stock Detected</h3>
                <p class="text-slate-400 font-medium max-w-sm mx-auto mb-10">All listed produce has been secured. Check back soon for the next harvest cycle.</p>
                <a href="{{ route('marketplace') }}" class="text-green-600 font-black uppercase tracking-widest text-xs hover:underline decoration-4 underline-offset-8">Reset Market Filters</a>
            </div>
        @endforelse
    </div>

    <div class="mt-20 flex justify-center">
        {{ $products->links() }}
    </div>
</div>
@endsection
