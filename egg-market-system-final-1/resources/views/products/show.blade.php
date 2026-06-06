@extends('layouts.main')

@section('title', $product->name . ' | EggMarket')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <!-- Breadcrumbs -->
    <nav class="flex mb-8 text-[10px] font-black uppercase tracking-widest text-gray-400">
        <a href="{{ route('marketplace') }}" class="hover:text-green-600 transition-colors">Marketplace</a>
        <span class="mx-3 text-gray-200">/</span>
        <span class="text-gray-900">{{ $product->category->name ?? 'Fresh Eggs' }}</span>
    </nav>

    <div class="grid lg:grid-cols-2 gap-16 items-start">
        <!-- Product Image -->
        <div class="relative">
            <div class="bg-white p-4 rounded-[48px] border border-gray-100 shadow-sm overflow-hidden group">
                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-auto rounded-[32px] object-cover group-hover:scale-105 transition-transform duration-700">
            </div>
            @if($product->stock < 15)
                <div class="absolute top-8 left-8 bg-red-500 text-white px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest animate-pulse shadow-lg shadow-red-200">
                    Low Stock Alert
                </div>
            @endif
        </div>

        <!-- Product Details -->
        <div class="py-6">
            <div class="flex items-center gap-3 mb-6">
                <span class="bg-green-50 text-green-700 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest">Verified Supplier</span>
                <div class="flex text-yellow-400">
                    <i class="fas fa-star text-xs"></i>
                    <i class="fas fa-star text-xs"></i>
                    <i class="fas fa-star text-xs"></i>
                    <i class="fas fa-star text-xs"></i>
                    <i class="fas fa-star text-xs"></i>
                </div>
            </div>

            <h1 class="text-5xl font-black text-gray-900 mb-4 leading-tight">{{ $product->name }}</h1>
            <p class="text-xl text-gray-500 font-medium mb-8 leading-relaxed">{{ $product->description }}</p>

            <div class="grid grid-cols-2 gap-6 mb-10">
                <div class="bg-white p-6 rounded-[32px] border border-gray-100 shadow-sm">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Current Price</p>
                    <p class="text-3xl font-black text-gray-900">₱{{ number_format($product->price, 2) }}<span class="text-xs ml-1 text-gray-400">/{{ $product->unit ?? 'Tray' }}</span></p>
                </div>
                <div class="bg-white p-6 rounded-[32px] border border-gray-100 shadow-sm">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Stock Availability</p>
                    <p class="text-3xl font-black {{ $product->stock < 15 ? 'text-red-500' : 'text-green-600' }}">{{ $product->stock }} <span class="text-xs ml-1 text-gray-400 uppercase">Units</span></p>
                </div>
            </div>

            <div class="bg-gray-900 p-8 rounded-[40px] mb-10 text-white shadow-2xl shadow-gray-200">
                <div class="flex items-center justify-between gap-8">
                    <div class="flex-1">
                        <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1">Supplier Farm</p>
                        <h4 class="text-xl font-black">{{ $product->user->farm_name ?? $product->user->name }}</h4>
                        <p class="text-[10px] font-bold text-green-400 uppercase mt-1 flex items-center gap-1">
                            <i class="fas fa-map-marker-alt"></i> {{ $product->user->address }}
                        </p>
                    </div>
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-green-500 text-white px-10 py-5 rounded-[24px] font-black text-lg hover:bg-green-400 transition-all flex items-center gap-3 shadow-xl shadow-green-900/20 active:scale-95">
                            <i class="fas fa-shopping-basket"></i> Add to Cart
                        </button>
                    </form>
                </div>
            </div>

            <!-- Guidelines -->
            <div class="flex flex-wrap gap-8 text-[10px] font-black uppercase tracking-widest text-gray-400 mb-10">
                <div class="flex items-center gap-2"><i class="fas fa-truck text-green-600"></i> Next Day Delivery</div>
                <div class="flex items-center gap-2"><i class="fas fa-shield-alt text-green-600"></i> Quality Guaranteed</div>
                <div class="flex items-center gap-2"><i class="fas fa-hand-holding-usd text-green-600"></i> COD Available</div>
            </div>

            <!-- Farm Location Map -->
            <div class="bg-white p-6 rounded-[32px] border border-gray-100 shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Farm Location</p>
                    @if($product->user->latitude && $product->user->longitude)
                        <a href="https://www.google.com/maps/search/?api=1&query={{ $product->user->latitude }},{{ $product->user->longitude }}" target="_blank" class="text-[10px] font-black text-[#15803d] hover:text-[#166534] uppercase tracking-widest flex items-center gap-1 bg-[#f0fdf4] px-3 py-1.5 rounded-full border border-[#bbf7d0] transition-colors">
                            <i class="fas fa-map-marker-alt"></i> Open Google Maps
                        </a>
                    @endif
                </div>
                <div id="farmMap" class="h-48 w-full rounded-2xl border-2 border-gray-50"></div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        @if($product->user->latitude && $product->user->longitude)
            var fMap = L.map('farmMap').setView([{{ $product->user->latitude }}, {{ $product->user->longitude }}], 14);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(fMap);
            L.marker([{{ $product->user->latitude }}, {{ $product->user->longitude }}]).addTo(fMap);
        @endif
    </script>
</div>
@endsection
