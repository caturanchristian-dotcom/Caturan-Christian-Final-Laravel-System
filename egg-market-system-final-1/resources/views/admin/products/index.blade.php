@extends('layouts.main')

@section('title', 'Global Inventory Audit | Command Center')

@section('content')
<div class="animate-in fade-in duration-700 pb-20">
    <!-- Sophisticated Header -->
    <div class="bg-white border-b border-slate-100 shadow-sm relative z-20">
        <div class="max-w-7xl mx-auto px-8 py-12">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-8">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                        <span class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Market Integrity Protocol</span>
                    </div>
                    <h1 class="text-5xl font-black text-slate-900 tracking-tighter">Inventory Audit</h1>
                    <p class="text-slate-400 font-semibold mt-1">Cross-node monitoring of active exchange listings.</p>
                </div>
                
                <form action="{{ route('admin.products.index') }}" method="GET" class="w-full lg:w-auto">
                    <div class="relative group">
                        <i class="fas fa-search absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-green-600 transition-colors"></i>
                        <input type="text" name="search" placeholder="Search across all farm nodes..." value="{{ request('search') }}" 
                               class="w-full lg:w-96 pl-14 pr-8 py-5 rounded-[28px] border-slate-100 bg-slate-50 focus:bg-white focus:ring-4 focus:ring-green-500/10 focus:border-green-500 transition-all font-bold text-sm shadow-inner">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-8 py-12">
        <!-- Global Audit Grid -->
        <div class="bg-white rounded-[50px] border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                        <tr>
                            <th class="px-10 py-8 text-center">Reference</th>
                            <th class="px-10 py-8">Produce Node Intelligence</th>
                            <th class="px-10 py-8">Origin Farmer</th>
                            <th class="px-10 py-8">Tier</th>
                            <th class="px-10 py-8 text-center">Stock Node</th>
                            <th class="px-10 py-8">Unit Value</th>
                            <th class="px-10 py-8 text-right">Protocol</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($products as $product)
                            <tr class="hover:bg-slate-50/40 transition-all group">
                                <td class="px-10 py-10 text-center">
                                    <span class="font-black text-slate-300 text-xs tracking-tighter">#ID-{{ $product->id }}</span>
                                </td>
                                <td class="px-10 py-10">
                                    <div class="flex items-center gap-6">
                                        <div class="relative shrink-0">
                                            <img src="{{ $product->image }}" class="w-16 h-16 rounded-[24px] object-cover shadow-2xl shadow-slate-200 group-hover:scale-105 transition-transform duration-500" alt="">
                                            <div class="absolute -top-2 -right-2 w-6 h-6 bg-white rounded-full flex items-center justify-center shadow-lg border border-slate-50">
                                                <i class="fas fa-check-circle text-emerald-500 text-[10px]"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="font-black text-slate-900 text-lg leading-tight">{{ $product->name }}</p>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Verified Listing</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-10 py-10">
                                    <a href="{{ route('admin.suppliers.show', $product->user_id) }}" class="inline-flex items-center gap-3 group/link">
                                        <div class="w-8 h-8 bg-slate-900 rounded-lg flex items-center justify-center text-white text-[10px] font-black group-hover/link:bg-green-600 transition-colors">
                                            {{ strtoupper(substr($product->user->name, 0, 1)) }}
                                        </div>
                                        <span class="font-bold text-slate-700 group-hover/link:text-green-600 transition-colors">{{ $product->user->farm_name ?? $product->user->name }}</span>
                                    </a>
                                </td>
                                <td class="px-10 py-10">
                                    @php
                                        $catName = strtolower($product->category->name);
                                        $catBadge = 'bg-slate-100 text-slate-600';
                                        if(str_contains($catName, 'chicken')) $catBadge = 'bg-orange-100 text-orange-700';
                                        elseif(str_contains($catName, 'duck')) $catBadge = 'bg-blue-100 text-blue-700';
                                        elseif(str_contains($catName, 'organic')) $catBadge = 'bg-emerald-100 text-emerald-700';
                                    @endphp
                                    <span class="px-4 py-1.5 rounded-xl font-black text-[10px] uppercase tracking-widest {{ $catBadge }}">
                                        {{ $product->category->name }}
                                    </span>
                                </td>
                                <td class="px-10 py-10 text-center">
                                    <div class="inline-flex flex-col items-center">
                                        <span class="text-lg font-black text-slate-900 leading-none">{{ $product->stock }}</span>
                                        <span class="text-[8px] font-black text-slate-400 uppercase tracking-[0.2em] mt-1">{{ $product->unit }}s</span>
                                        @if($product->stock < 15)
                                            <div class="mt-2 w-full h-1 bg-slate-100 rounded-full overflow-hidden">
                                                <div class="bg-rose-500 h-full w-1/3 animate-pulse"></div>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-10 py-10 font-black text-slate-900 text-xl tracking-tighter">
                                    ₱{{ number_format($product->price, 2) }}
                                </td>
                                <td class="px-10 py-10 text-right">
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('MODERATION PROTOCOL: This action will permanently remove the listing node from the market. Proceed?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="w-12 h-12 flex items-center justify-center rounded-2xl bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition-all shadow-sm group/btn active:scale-90">
                                            <i class="fas fa-trash-can text-sm group-hover/btn:rotate-12 transition-transform"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-40 text-center">
                                    <div class="w-24 h-24 bg-slate-50 text-slate-200 rounded-[40px] flex items-center justify-center mx-auto mb-8">
                                        <i class="fas fa-barcode text-4xl"></i>
                                    </div>
                                    <h3 class="text-2xl font-black text-slate-900 mb-2">No Nodes Detected</h3>
                                    <p class="text-slate-400 font-medium max-w-sm mx-auto">The exchange registry is currently empty or filtering returned zero matches.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Professional Pagination -->
        <div class="mt-16 flex justify-center">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
