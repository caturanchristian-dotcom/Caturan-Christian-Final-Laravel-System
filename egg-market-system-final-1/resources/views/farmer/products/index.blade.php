@extends('layouts.main')

@section('title', 'Market Node Inventory | EggMarket')

@section('content')
<div class="animate-in fade-in duration-700 pb-20">
    <!-- Sophisticated Header Protocol -->
    <div class="bg-white border-b border-slate-100 shadow-sm relative z-20">
        <div class="max-w-7xl mx-auto px-8 py-10">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-8">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></div>
                        <span class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Inventory Exchange Protocol</span>
                    </div>
                    <h1 class="text-4xl font-black text-slate-900 tracking-tight">Supply Nodes</h1>
                    <p class="text-slate-400 font-semibold mt-1">Direct management of your active trade listings.</p>
                </div>
                
                <div class="flex gap-4">
                    <button onclick="document.getElementById('categoryModal').classList.remove('hidden')" class="px-8 py-4 bg-white border-2 border-slate-100 text-slate-900 rounded-[22px] font-black text-xs uppercase tracking-widest hover:bg-slate-50 hover:border-slate-200 transition-all flex items-center gap-3">
                        <i class="fas fa-folder-plus text-green-600"></i> New Category
                    </button>
                    <button onclick="document.getElementById('addModal').classList.remove('hidden')" class="px-8 py-4 bg-slate-900 text-white rounded-[22px] font-black text-xs uppercase tracking-widest hover:bg-black shadow-2xl shadow-slate-200 transition-all flex items-center gap-3 active:scale-95">
                        <i class="fas fa-plus text-slate-400"></i> List Produce
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-8 py-12">
        <!-- Elite Inventory Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">
            @foreach($products as $product)
                <div class="bg-white rounded-[48px] border border-slate-100 overflow-hidden shadow-sm hover:shadow-[0_40px_100px_-20px_rgba(0,0,0,0.1)] transition-all duration-700 group flex flex-col">
                    <div class="relative aspect-[4/5] overflow-hidden">
                        <img src="{{ $product->image }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        <!-- Protocol Actions -->
                        <div class="absolute top-6 right-6 flex flex-col gap-2 translate-x-12 opacity-0 group-hover:translate-x-0 group-hover:opacity-100 transition-all duration-500">
                            <button onclick='openEditModal(@json($product))' class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-blue-600 shadow-xl hover:bg-blue-600 hover:text-white transition-all">
                                <i class="fas fa-sliders text-sm"></i>
                            </button>
                            <form action="{{ route('farmer.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('IDENTITY PROTOCOL: Purge this listing from the exchange?')">
                                @csrf @method('DELETE')
                                <button class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-rose-500 shadow-xl hover:bg-rose-500 hover:text-white transition-all">
                                    <i class="fas fa-trash-can text-sm"></i>
                                </button>
                            </form>
                        </div>

                        <span class="absolute top-6 left-6 backdrop-blur-md bg-white/90 px-4 py-2 rounded-2xl text-[10px] font-black text-slate-900 uppercase tracking-widest shadow-xl">
                            {{ $product->category->name }}
                        </span>
                    </div>
                    
                    <div class="p-8 flex-1 flex flex-col">
                        <h3 class="text-2xl font-black text-slate-900 mb-6 leading-tight truncate group-hover:text-green-600 transition-colors">{{ $product->name }}</h3>
                        
                        <div class="grid grid-cols-2 gap-4 mb-8">
                            <div class="bg-slate-50 p-5 rounded-[32px] text-center">
                                <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest mb-1">Exchange Rate</p>
                                <p class="text-2xl font-black text-slate-900">₱{{ number_format($product->price, 0) }}</p>
                            </div>
                            <div class="bg-slate-50 p-5 rounded-[32px] text-center border-2 border-transparent {{ $product->stock < 15 ? 'border-rose-100 bg-rose-50' : '' }}">
                                <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest mb-1">Stock Node</p>
                                <p class="text-2xl font-black {{ $product->stock < 15 ? 'text-rose-500' : 'text-slate-900' }}">{{ $product->stock }}</p>
                            </div>
                        </div>

                        <div class="mt-auto flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.5)]"></div>
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Node Sync Active</span>
                            </div>
                            <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">{{ $product->unit }} Unit</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Add Modal -->
<div id="addModal" class="hidden fixed inset-0 z-[100] bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-[60px] w-full max-w-xl shadow-2xl animate-in zoom-in-95 duration-200 flex flex-col max-h-[90vh]">
        <div class="p-10 border-b border-slate-50 flex justify-between items-center bg-white rounded-t-[60px]">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Deploy Produce</h2>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-1">Initiate new market listing node</p>
            </div>
            <button onclick="document.getElementById('addModal').classList.add('hidden')" class="w-12 h-12 rounded-2xl bg-slate-50 text-slate-400 hover:text-rose-500 transition-all flex items-center justify-center">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        
        <div class="flex-1 overflow-y-auto p-12 custom-scrollbar bg-white">
            <form id="addProductForm" action="{{ route('farmer.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                <div class="flex justify-center mb-10">
                    <div id="add_preview_container" class="w-48 h-48 rounded-[48px] bg-slate-50 border-2 border-dashed border-slate-200 flex items-center justify-center overflow-hidden transition-all duration-500">
                        <img id="add_preview_img" src="" class="hidden w-full h-full object-cover">
                        <div id="add_preview_placeholder" class="text-center p-6">
                            <i class="fas fa-camera text-slate-200 fa-3x mb-4"></i>
                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest leading-tight">Visual Sensor <br/> Required</p>
                        </div>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block ml-1">Upload Protocol</label>
                        <input type="file" name="product_image" onchange="previewNewImage(this)" accept="image/webp, image/jpeg, image/png" class="w-full bg-slate-50 border-none rounded-2xl p-5 font-bold text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-blue-600 file:text-white cursor-pointer">
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block ml-1">Direct Link (URL)</label>
                        <input type="text" name="image_url" oninput="previewFromUrl(this)" class="w-full bg-slate-50 border-none rounded-2xl p-5 font-bold text-sm focus:ring-4 focus:ring-green-500/10" placeholder="https://...">
                    </div>
                </div>

                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block ml-1">Product Designation</label>
                    <input type="text" name="name" required class="w-full bg-slate-50 border-none rounded-2xl p-5 font-bold text-sm focus:ring-4 focus:ring-green-500/10" placeholder="e.g. XL Brown Eggs">
                </div>

                <div class="grid grid-cols-2 gap-8">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block ml-1">Exchange Rate (₱)</label>
                        <input type="number" step="0.01" name="price" required class="w-full bg-slate-50 border-none rounded-2xl p-5 font-bold text-sm">
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block ml-1">Stock Node Capacity</label>
                        <input type="number" name="stock" required class="w-full bg-slate-50 border-none rounded-2xl p-5 font-bold text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-8">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block ml-1">Trade Tier</label>
                        <select name="category_id" class="w-full bg-slate-50 border-none rounded-2xl p-5 font-bold text-sm">
                            @foreach(\App\Models\Category::all() as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block ml-1">Exchange Unit</label>
                        <select name="unit" class="w-full bg-slate-50 border-none rounded-2xl p-5 font-bold text-sm">
                            <option value="Tray">Tray</option>
                            <option value="Dozen">Dozen</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block ml-1">Description Logic</label>
                    <textarea name="description" rows="3" class="w-full bg-slate-50 border-none rounded-2xl p-5 font-bold text-sm focus:ring-4 focus:ring-green-500/10" placeholder="Tell us about the quality..."></textarea>
                </div>
            </form>
        </div>

        <div class="p-10 bg-slate-50 border-t border-slate-100 rounded-b-[60px]">
            <button type="submit" form="addProductForm" class="w-full bg-slate-900 text-white py-6 rounded-[28px] font-black uppercase tracking-widest hover:bg-black shadow-2xl shadow-slate-200 transition-all active:scale-95">
                Commit Protocol
            </button>
        </div>
    </div>
</div>

<!-- Category Modal -->
<div id="categoryModal" class="hidden fixed inset-0 z-[110] bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-6">
    <div class="bg-white rounded-[50px] w-full max-w-md shadow-2xl animate-in zoom-in-95 duration-200">
        <div class="p-10 border-b border-slate-50 flex justify-between items-center">
            <h2 class="text-2xl font-black text-slate-900">New Category</h2>
            <button onclick="document.getElementById('categoryModal').classList.add('hidden')" class="w-12 h-12 rounded-2xl bg-slate-50 text-slate-400 hover:text-rose-500 transition-all flex items-center justify-center">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="{{ route('farmer.categories.store') }}" method="POST" class="p-10 space-y-8">
            @csrf
            <div>
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block ml-1">Category Node Name</label>
                <input type="text" name="category_name" required class="w-full bg-slate-50 border-none rounded-2xl p-5 font-bold text-sm focus:ring-4 focus:ring-green-500/10" placeholder="e.g. Quail Eggs">
            </div>
            <button type="submit" class="w-full bg-slate-900 text-white py-5 rounded-[24px] font-black uppercase tracking-widest hover:bg-black transition-all">Create Category</button>
        </form>
    </div>
</div>

<!-- Edit Modal Redesigned -->
<div id="editModal" class="hidden fixed inset-0 z-[100] bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-[60px] w-full max-w-xl shadow-2xl animate-in zoom-in-95 duration-200 flex flex-col max-h-[90vh]">
        <div class="p-10 border-b border-slate-50 flex justify-between items-center bg-white rounded-t-[60px]">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Optimize Node</h2>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-1">Direct listing parameter adjustment</p>
            </div>
            <button onclick="document.getElementById('editModal').classList.add('hidden')" class="w-12 h-12 rounded-2xl bg-slate-50 text-slate-400 hover:text-rose-500 transition-all flex items-center justify-center">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        
        <div class="flex-1 overflow-y-auto p-12 custom-scrollbar bg-white">
            <form id="editForm" action="" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PATCH')
                
                <div class="flex justify-center mb-10">
                    <div class="relative group">
                        <img id="edit_preview" src="" class="w-40 h-40 rounded-[48px] object-cover border-4 border-slate-50 shadow-2xl shadow-slate-200">
                        <div class="absolute inset-0 flex items-center justify-center bg-slate-900/40 rounded-[48px] opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                            <i class="fas fa-camera text-white text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block ml-1">New Protocol File</label>
                        <input type="file" name="product_image" onchange="previewNewImageEdit(this)" accept="image/webp, image/jpeg, image/png" class="w-full bg-slate-50 border-none rounded-2xl p-5 font-bold text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-blue-600 file:text-white cursor-pointer">
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block ml-1">New Link (URL)</label>
                        <input type="text" name="image_url" id="edit_image_url" oninput="previewFromUrlEdit(this)" class="w-full bg-slate-50 border-none rounded-2xl p-5 font-bold text-sm focus:ring-4 focus:ring-blue-500/10" placeholder="https://...">
                    </div>
                </div>

                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block ml-1">Entity Name</label>
                    <input type="text" id="edit_name" name="name" required class="w-full bg-slate-50 border-none rounded-2xl p-5 font-bold text-sm focus:ring-4 focus:ring-blue-500/10">
                </div>

                <div class="grid grid-cols-2 gap-8">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block ml-1">Valuation (₱)</label>
                        <input type="number" step="0.01" id="edit_price" name="price" required class="w-full bg-slate-50 border-none rounded-2xl p-5 font-bold text-sm">
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block ml-1">Volume Stock</label>
                        <input type="number" id="edit_stock" name="stock" required class="w-full bg-slate-50 border-none rounded-2xl p-5 font-bold text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-8">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block ml-1">Trade Tier</label>
                        <select name="category_id" id="edit_category_id" class="w-full bg-slate-50 border-none rounded-2xl p-5 font-bold text-sm">
                            @foreach(\App\Models\Category::all() as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block ml-1">Exchange Unit</label>
                        <select name="unit" id="edit_unit" class="w-full bg-slate-50 border-none rounded-2xl p-5 font-bold text-sm">
                            <option value="Tray">Tray</option>
                            <option value="Dozen">Dozen</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block ml-1">Description Protocol</label>
                    <textarea id="edit_description" name="description" rows="3" class="w-full bg-slate-50 border-none rounded-2xl p-5 font-bold text-sm focus:ring-4 focus:ring-blue-500/10"></textarea>
                </div>
            </form>
        </div>

        <div class="p-10 bg-slate-50 border-t border-slate-100 rounded-b-[60px]">
            <button type="submit" form="editForm" class="w-full bg-blue-600 text-white py-6 rounded-[28px] font-black uppercase tracking-widest hover:bg-blue-700 shadow-2xl shadow-blue-100 transition-all active:scale-95">
                Commit Logic Update
            </button>
        </div>
    </div>
</div>

<script>
    function previewNewImage(input) {
        const placeholder = document.getElementById('add_preview_placeholder');
        const img = document.getElementById('add_preview_img');
        const container = document.getElementById('add_preview_container');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                img.classList.remove('hidden');
                placeholder.classList.add('hidden');
                container.classList.remove('border-dashed');
                container.classList.add('border-solid', 'border-green-100');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    function previewFromUrl(input) {
        const img = document.getElementById('add_preview_img');
        const placeholder = document.getElementById('add_preview_placeholder');
        const container = document.getElementById('add_preview_container');
        if (input.value) {
            img.src = input.value;
            img.classList.remove('hidden');
            placeholder.classList.add('hidden');
            container.classList.remove('border-dashed');
        }
    }
    function previewNewImageEdit(input) {
        const img = document.getElementById('edit_preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = (e) => img.src = e.target.result;
            reader.readAsDataURL(input.files[0]);
        }
    }
    function previewFromUrlEdit(input) {
        if (input.value) document.getElementById('edit_preview').src = input.value;
    }
    function openEditModal(product) {
        const modal = document.getElementById('editModal');
        const form = document.getElementById('editForm');
        form.action = `/farmer/products/${product.id}`;
        document.getElementById('edit_name').value = product.name;
        document.getElementById('edit_price').value = product.price;
        document.getElementById('edit_stock').value = product.stock;
        document.getElementById('edit_category_id').value = product.category_id;
        document.getElementById('edit_unit').value = product.unit;
        document.getElementById('edit_description').value = product.description;
        document.getElementById('edit_preview').src = product.image ? product.image : 'https://images.unsplash.com/photo-1506976785307-8732e854ad03?w=400';
        const urlInput = document.getElementById('edit_image_url');
        if (product.image && (product.image.startsWith('http'))) urlInput.value = product.image;
        else urlInput.value = '';
        modal.classList.remove('hidden');
    }
</script>
@endsection
