@extends('layouts.main')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <div class="mb-12 flex justify-between items-end">
        <div>
            <h1 class="text-4xl font-black text-gray-900 tracking-tight">Farm Performance Reports</h1>
            <p class="text-gray-500 font-medium mt-2">Analytical insights into your agricultural trade.</p>
        </div>
        <button class="bg-gray-900 text-white px-8 py-3 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-black transition-all">
            <i class="fas fa-download mr-2"></i> Export Data
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        <!-- Sales by Category -->
        <div class="bg-white p-10 rounded-[40px] border border-gray-100 shadow-sm">
            <h3 class="text-xl font-black text-gray-900 mb-8 flex items-center gap-3">
                <i class="fas fa-chart-pie text-green-600"></i> Category Distribution
            </h3>
            <div class="space-y-6">
                @foreach($salesByCategory as $stat)
                    <div>
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-xs font-black text-gray-400 uppercase tracking-widest">
                                @if($stat->category_id == 1) Chicken Eggs @elseif($stat->category_id == 2) Duck Eggs @else Organic @endif
                            </span>
                            <span class="text-sm font-black text-gray-900">{{ $stat->total }} Listings</span>
                        </div>
                        <div class="w-full bg-gray-50 h-3 rounded-full overflow-hidden">
                            <div class="bg-green-600 h-full rounded-full" style="width: {{ ($stat->total / 10) * 100 }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Growth Indicator -->
        <div class="bg-white p-10 rounded-[40px] border border-gray-100 shadow-sm flex flex-col items-center justify-center text-center">
            <div class="w-24 h-24 bg-green-50 text-green-600 rounded-full flex items-center justify-center mb-8">
                <i class="fas fa-seedling text-4xl"></i>
            </div>
            <h4 class="text-2xl font-black text-gray-900 mb-2">Revenue Growth</h4>
            <p class="text-gray-500 font-medium max-w-xs mb-8">You have seen a significant increase in demand over the last 30 days.</p>
            <div class="text-6xl font-black text-gray-900 tracking-tighter">+18.4%</div>
            <p class="text-[10px] font-black text-green-600 uppercase tracking-widest mt-2">Performance vs Previous Month</p>
        </div>
    </div>
</div>
@endsection
