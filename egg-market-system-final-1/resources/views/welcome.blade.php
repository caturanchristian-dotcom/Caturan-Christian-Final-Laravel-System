@extends('layouts.main')

@section('content')
<div class="animate-in fade-in duration-1000 scroll-smooth">
    
    <!-- Hero Section: Ultra-Modern Agri-Tech -->
    <section class="relative min-h-[95vh] flex items-center pt-20 overflow-hidden bg-white">
        <!-- Modern Abstract Background -->
        <div class="absolute top-[-10%] right-[-5%] w-[60%] h-[120%] bg-gradient-to-br from-green-50 to-emerald-50/30 rounded-l-[200px] -z-10 hidden lg:block rotate-[-5deg]"></div>
        <div class="absolute top-[20%] right-[10%] w-64 h-64 bg-green-200/20 blur-[100px] rounded-full -z-10 animate-pulse"></div>
        
        <div class="max-w-7xl mx-auto px-6 lg:px-8 grid lg:grid-cols-2 gap-16 items-center">
            <div class="space-y-10">
                <div class="inline-flex items-center gap-3 px-5 py-2.5 rounded-full bg-white border border-slate-100 shadow-sm text-green-700 text-xs font-black uppercase tracking-[0.2em]">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-2 rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                    </span>
                    Live Agricultural Node Active
                </div>
                
                <h1 class="text-7xl lg:text-[100px] font-black text-slate-900 leading-[0.85] tracking-tighter">
                    Egg Trade <br/> <span class="text-green-600">Reinvented.</span>
                </h1>
                
                <p class="text-xl text-slate-500 font-medium max-w-lg leading-relaxed border-l-4 border-green-500 pl-6 py-2">
                    The region's premier digital exchange. Direct farm-to-consumer protocols for elite quality and precision logistics.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-6">
                    <a href="{{ route('marketplace') }}" class="group relative px-12 py-6 bg-slate-900 text-white rounded-[24px] font-black text-lg overflow-hidden transition-all hover:scale-105 active:scale-95 shadow-[0_20px_50px_rgba(0,0,0,0.2)]">
                        <span class="relative z-10 flex items-center justify-center gap-3">
                            Access Exchange <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                        </span>
                    </a>
                    <a href="{{ route('register') }}" class="px-12 py-6 bg-white border-2 border-slate-100 text-slate-900 rounded-[24px] font-black text-lg hover:bg-slate-50 hover:border-slate-200 transition-all text-center">
                        Supplier Onboarding
                    </a>
                </div>
                
                <!-- Advanced Meta Info -->
                <div class="pt-8 flex flex-wrap items-center gap-10 opacity-60">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-shield-halved text-green-600"></i>
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-900">Encrypted Trade</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="fas fa-location-dot text-green-600"></i>
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-900">GPS Verified</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="fas fa-certificate text-green-600"></i>
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-900">Global Standard</span>
                    </div>
                </div>
            </div>

            <!-- Hero High-Fidelity Visual -->
            <div class="relative hidden lg:block">
                <div class="relative z-10 p-2 bg-gradient-to-br from-white to-slate-50 rounded-[60px] shadow-2xl border border-slate-100">
                    <img src="https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?w=1000&q=80" 
                         class="w-full h-[600px] object-cover rounded-[55px]" alt="Agricultural Production">
                    
                    <!-- Floating Data Module -->
                    <div class="absolute -bottom-10 -right-10 bg-white p-8 rounded-[40px] shadow-[0_50px_100px_-20px_rgba(0,0,0,0.15)] border border-slate-50 animate-in slide-in-from-bottom duration-1000 delay-300">
                        <div class="flex items-center gap-6">
                            <div class="w-16 h-16 bg-green-600 rounded-3xl flex items-center justify-center text-white text-2xl shadow-xl shadow-green-200">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div>
                                <p class="text-4xl font-black text-slate-900 leading-none">₱{{ number_format($stats['revenue'] / 1000, 1) }}k</p>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Network Trade Volume</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Professional Trust Corridor (Stats) -->
    <section class="bg-slate-900 py-16">
        <div class="max-w-7xl mx-auto px-8 flex flex-wrap justify-between items-center gap-12 lg:gap-0">
            <div class="flex-1 text-center border-r border-slate-800 lg:px-4">
                <p class="text-5xl font-black text-white leading-none mb-2 tracking-tighter">{{ $stats['farmers'] + 120 }}+</p>
                <p class="text-[10px] font-black text-green-500 uppercase tracking-[0.3em]">Verified Suppliers</p>
            </div>
            <div class="flex-1 text-center border-r border-slate-800 lg:px-4">
                <p class="text-5xl font-black text-white leading-none mb-2 tracking-tighter">99.9%</p>
                <p class="text-[10px] font-black text-green-500 uppercase tracking-[0.3em]">Protocol Uptime</p>
            </div>
            <div class="flex-1 text-center border-r border-slate-800 lg:px-4">
                <p class="text-5xl font-black text-white leading-none mb-2 tracking-tighter">{{ $stats['orders'] + 450 }}+</p>
                <p class="text-[10px] font-black text-green-500 uppercase tracking-[0.3em]">Active Contracts</p>
            </div>
            <div class="flex-1 text-center lg:px-4">
                <p class="text-5xl font-black text-white leading-none mb-2 tracking-tighter">< 2hr</p>
                <p class="text-[10px] font-black text-green-500 uppercase tracking-[0.3em]">Avg. Sync Speed</p>
            </div>
        </div>
    </section>

    <!-- Strategic Tiers (Categories) -->
    <section class="py-32 bg-white">
        <div class="max-w-7xl mx-auto px-8">
            <div class="mb-20">
                <h2 class="text-xs font-black text-green-600 uppercase tracking-[0.4em] mb-4">Market Segments</h2>
                <h3 class="text-5xl font-black text-slate-900 tracking-tighter">Specialized Production Tiers.</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                @php
                    $tiers = [
                        ['name' => 'Chicken Eggs', 'desc' => 'High-volume standard commercial grade produce.', 'icon' => 'fa-egg', 'color' => 'orange'],
                        ['name' => 'Premium Duck', 'desc' => 'Rich profile selections for specialty trade.', 'icon' => 'fa-duck', 'color' => 'blue'],
                        ['name' => 'Eco Organic', 'desc' => 'Zero-intervention sustainable farm nodes.', 'icon' => 'fa-leaf', 'color' => 'emerald']
                    ];
                @endphp
                @foreach($tiers as $tier)
                    <div class="group p-12 rounded-[50px] bg-slate-50 border border-slate-100 hover:bg-white hover:shadow-2xl transition-all duration-700 cursor-pointer overflow-hidden relative">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-{{ $tier['color'] }}-500/5 rounded-bl-full group-hover:scale-150 transition-transform duration-700"></div>
                        <div class="relative z-10">
                            <div class="w-16 h-16 bg-white rounded-3xl flex items-center justify-center text-{{ $tier['color'] }}-600 mb-8 shadow-sm group-hover:bg-{{ $tier['color'] }}-600 group-hover:text-white transition-all duration-500">
                                <i class="fas {{ $tier['icon'] }} fa-2x"></i>
                            </div>
                            <h4 class="text-2xl font-black text-slate-900 mb-4">{{ $tier['name'] }}</h4>
                            <p class="text-slate-500 font-medium leading-relaxed">{{ $tier['desc'] }}</p>
                            <div class="mt-8 flex items-center gap-2 text-{{ $tier['color'] }}-600 font-black text-[10px] uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity">
                                View Segment <i class="fas fa-chevron-right text-[8px]"></i>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Global Listing Feed (Featured Products) -->
    <section class="py-32 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-20 gap-8">
                <div class="space-y-4">
                    <h2 class="text-xs font-black text-green-600 uppercase tracking-[0.4em]">Live Intelligence</h2>
                    <h3 class="text-5xl font-black text-slate-900 tracking-tighter leading-none">Fresh Harvest Log</h3>
                </div>
                <a href="{{ route('marketplace') }}" class="group px-10 py-5 bg-white border-2 border-slate-100 text-slate-900 rounded-[24px] font-black text-xs uppercase tracking-widest hover:bg-green-600 hover:text-white hover:border-green-600 transition-all shadow-sm">
                    Access Global Feed <i class="fas fa-barcode ml-2 opacity-30 group-hover:opacity-100 transition-opacity"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
                @foreach($featuredProducts as $product)
                    <div class="bg-white rounded-[48px] border border-slate-100 overflow-hidden hover:shadow-[0_50px_100px_-20px_rgba(0,0,0,0.1)] transition-all duration-700 group flex flex-col">
                        <a href="{{ route('products.show', $product->id) }}" class="block overflow-hidden relative aspect-[1/1.2]">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            
                            @php
                                $catName = strtolower($product->category->name ?? 'Chicken');
                                $catClass = 'bg-white/90 text-slate-900';
                                if (str_contains($catName, 'chicken')) $catClass = 'bg-orange-500 text-white';
                                elseif (str_contains($catName, 'duck')) $catClass = 'bg-blue-600 text-white';
                                elseif (str_contains($catName, 'organic')) $catClass = 'bg-emerald-500 text-white';
                            @endphp
                            <span class="absolute top-6 left-6 backdrop-blur-md px-4 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl {{ $catClass }}">
                                {{ $product->category->name }}
                            </span>
                        </a>
                        <div class="p-10 flex-1 flex flex-col">
                            <div class="flex items-center gap-2 mb-2">
                                <i class="fas fa-tractor text-[10px] text-green-600"></i>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $product->user->farm_name ?? 'Local Farm' }}</p>
                            </div>
                            <h4 class="text-2xl font-black text-slate-900 mb-8 leading-tight truncate group-hover:text-green-600 transition-colors">{{ $product->name }}</h4>
                            
                            <div class="mt-auto pt-8 flex justify-between items-center border-t border-slate-50">
                                <div>
                                    <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest mb-1">Exchange Rate</p>
                                    <div class="flex items-baseline">
                                        <span class="text-3xl font-black text-slate-900">₱{{ number_format($product->price, 0) }}</span>
                                        <span class="text-sm font-black text-slate-400 ml-1">/ {{ $product->unit ?? 'Tray' }}</span>
                                    </div>
                                </div>
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button class="bg-slate-900 text-white w-14 h-14 rounded-[22px] flex items-center justify-center hover:bg-green-600 shadow-2xl shadow-slate-100 transition-all hover:scale-110 active:scale-95">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- High-Impact CTA Node -->
    <section class="max-w-7xl mx-auto px-8 py-32">
        <div class="relative rounded-[70px] bg-slate-900 p-16 lg:p-32 overflow-hidden shadow-[0_50px_100px_-20px_rgba(0,0,0,0.3)]">
            <!-- Sophisticated Design Elements -->
            <div class="absolute top-0 right-0 w-[40%] h-full bg-green-600 rounded-l-full opacity-10"></div>
            <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-green-600/20 blur-[100px] rounded-full"></div>
            
            <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-16">
                <div class="max-w-2xl text-center lg:text-left space-y-8">
                    <h2 class="text-6xl lg:text-8xl font-black text-white tracking-tighter leading-[0.85]">Join the <br/> Network.</h2>
                    <p class="text-xl text-slate-400 font-medium leading-relaxed">System-wide on-boarding is active. Secure your node in the region's largest egg trade matrix.</p>
                    <div class="flex flex-col sm:flex-row gap-5 pt-4">
                        <a href="{{ route('register') }}" class="px-12 py-6 bg-green-600 text-white rounded-[24px] font-black text-lg hover:bg-green-500 shadow-2xl shadow-green-900/40 transition-all hover:scale-105 active:scale-95 text-center">Protocol Registration</a>
                        <a href="/contact" class="px-12 py-6 bg-slate-800 text-slate-300 rounded-[24px] font-black text-lg hover:bg-slate-700 transition-all text-center">Technical Inquiry</a>
                    </div>
                </div>
                
                <div class="hidden lg:grid grid-cols-1 gap-6 w-full max-w-xs">
                    <div class="p-8 bg-white/5 backdrop-blur-xl rounded-[32px] border border-white/10 space-y-2">
                        <p class="text-4xl font-black text-green-500 tracking-tighter">98.4%</p>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Supplier Retention</p>
                    </div>
                    <div class="p-8 bg-white/5 backdrop-blur-xl rounded-[32px] border border-white/10 space-y-2">
                        <p class="text-4xl font-black text-green-500 tracking-tighter">Instant</p>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Trade Settlement</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection
