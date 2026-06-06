@extends('layouts.main')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <div class="grid lg:grid-cols-3 gap-10">
        <div class="lg:col-span-1">
            <h1 class="text-4xl font-black text-gray-900 tracking-tight mb-4">Market Guidelines</h1>
            <p class="text-gray-500 font-medium mb-10 leading-relaxed">Configure product categories and system-wide trade parameters.</p>
            
            <form action="{{ route('admin.categories.store') }}" method="POST" class="bg-white p-10 rounded-[40px] border border-gray-100 shadow-sm">
                @csrf
                <h3 class="text-lg font-black text-gray-900 mb-6">Create Category</h3>
                <div class="mb-6">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 block ml-1">Category Name</label>
                    <input type="text" name="name" required class="w-full bg-gray-50 border-none rounded-2xl p-4 font-bold text-sm focus:ring-2 focus:ring-green-500" placeholder="e.g. Quail Eggs">
                </div>
                <button type="submit" class="w-full bg-green-600 text-white py-5 rounded-[24px] font-black uppercase tracking-widest hover:bg-green-700 shadow-xl shadow-green-100 transition-all">Add Category</button>
            </form>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-[40px] border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-8 border-b border-gray-50 flex justify-between items-center">
                    <h3 class="text-xl font-black text-gray-900">Active Trade Categories</h3>
                    <span class="bg-gray-100 px-4 py-1.5 rounded-xl font-black text-[10px] text-gray-400 uppercase tracking-widest">{{ $categories->count() }} Total</span>
                </div>
                <div class="divide-y divide-gray-50">
                    @foreach($categories as $cat)
                        <div class="p-8 flex items-center justify-between hover:bg-gray-50/50 transition-all group">
                            <div class="flex items-center gap-6">
                                <div class="w-14 h-14 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center text-xl font-black">
                                    {{ strtoupper(substr($cat->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h4 class="font-black text-gray-900 text-lg group-hover:text-green-600 transition-colors">{{ $cat->name }}</h4>
                                    <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mt-1">{{ $cat->products_count }} active listings</p>
                                </div>
                            </div>
                            <button class="w-12 h-12 rounded-2xl bg-gray-50 text-gray-300 hover:bg-red-50 hover:text-red-500 transition-all">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
