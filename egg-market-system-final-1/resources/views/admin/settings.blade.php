@extends('layouts.main')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-16">
    <h1 class="text-4xl font-black text-gray-900 tracking-tight mb-4">System Configurations</h1>
    <p class="text-gray-500 font-medium mb-12">Global parameters for the Egg Market Management System.</p>

    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8">
        @csrf
        
        <!-- Marketplace Settings -->
        <div class="bg-white p-12 rounded-[48px] border border-gray-100 shadow-sm">
            <h3 class="text-xl font-black text-gray-900 mb-8 flex items-center gap-3">
                <i class="fas fa-shopping-basket text-green-600"></i> Marketplace Controls
            </h3>
            
            <div class="grid md:grid-cols-2 gap-8">
                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 block ml-1">Platform Transaction Fee (%)</label>
                    <input type="number" value="2.5" class="w-full bg-gray-50 border-none rounded-2xl p-4 font-bold text-sm focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 block ml-1">Min. Listing Price (₱)</label>
                    <input type="number" value="100" class="w-full bg-gray-50 border-none rounded-2xl p-4 font-bold text-sm focus:ring-2 focus:ring-green-500">
                </div>
            </div>
            
            <div class="mt-8 flex items-center justify-between p-6 bg-gray-50 rounded-[24px]">
                <div>
                    <p class="font-black text-gray-900 text-sm">Farmer Verification Required</p>
                    <p class="text-xs text-gray-400 font-medium">New suppliers must be approved by admin before listing.</p>
                </div>
                <div class="relative inline-block w-12 h-6 rounded-full bg-green-500">
                    <div class="absolute right-1 top-1 bg-white w-4 h-4 rounded-full"></div>
                </div>
            </div>
        </div>

        <!-- Notification Settings -->
        <div class="bg-white p-12 rounded-[48px] border border-gray-100 shadow-sm">
            <h3 class="text-xl font-black text-gray-900 mb-8 flex items-center gap-3">
                <i class="fas fa-bell text-blue-600"></i> Communication Engine
            </h3>
            <div class="space-y-6">
                <div class="flex items-center gap-4">
                    <input type="checkbox" checked class="w-6 h-6 rounded-lg text-green-600 border-gray-200 focus:ring-green-500">
                    <div>
                        <p class="font-black text-gray-900 text-sm">Low Stock Email Alerts</p>
                        <p class="text-xs text-gray-400 font-medium">Automatically notify farmers when inventory is low.</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <input type="checkbox" checked class="w-6 h-6 rounded-lg text-green-600 border-gray-200 focus:ring-green-500">
                    <div>
                        <p class="font-black text-gray-900 text-sm">Order Fulfillment Updates</p>
                        <p class="text-xs text-gray-400 font-medium">Notify customers about delivery progress.</p>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="w-full bg-gray-900 text-white py-6 rounded-[28px] font-black uppercase tracking-widest hover:bg-black shadow-2xl shadow-gray-200 transition-all flex items-center justify-center gap-3">
            <i class="fas fa-save"></i> Save Global Configurations
        </button>
    </form>
</div>
@endsection
