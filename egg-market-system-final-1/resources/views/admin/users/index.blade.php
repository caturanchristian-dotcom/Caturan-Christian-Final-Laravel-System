@extends('layouts.main')

@section('title', 'Network User Registry | Command Center')

@section('content')
<div class="animate-in fade-in duration-700 pb-20">
    <!-- Premium Header -->
    <div class="bg-white border-b border-slate-100 shadow-sm relative z-20">
        <div class="max-w-7xl mx-auto px-8 py-12">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-8">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></div>
                        <span class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Platform Registry Protocol</span>
                    </div>
                    <h1 class="text-5xl font-black text-slate-900 tracking-tighter">User Management</h1>
                    <p class="text-slate-400 font-semibold mt-1">Lifecycle governance for all network entities and farm nodes.</p>
                </div>
                
                <div class="flex flex-wrap gap-3">
                    <a href="?role=farmer" class="group px-6 py-3 bg-white border-2 border-slate-100 text-slate-500 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:border-green-100 hover:text-green-600 transition-all flex items-center gap-2">
                        <i class="fas fa-tractor text-slate-200 group-hover:text-green-600"></i> Farmers
                    </a>
                    <a href="?role=customer" class="group px-6 py-3 bg-white border-2 border-slate-100 text-slate-500 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:border-blue-100 hover:text-blue-600 transition-all flex items-center gap-2">
                        <i class="fas fa-shopping-basket text-slate-200 group-hover:text-blue-600"></i> Customers
                    </a>
                    <a href="?status=pending" class="px-6 py-3 bg-amber-50 text-amber-700 rounded-2xl font-black text-[10px] uppercase tracking-widest flex items-center gap-3 shadow-sm shadow-amber-100 border border-amber-100">
                        <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-ping"></span> 
                        Pending Nodes
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-8 py-12">
        <!-- Error & Success Feedback handled by layouts.main global system -->

        <!-- User Registry Grid -->
        <div class="bg-white rounded-[50px] border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                        <tr>
                            <th class="px-10 py-8">Entity Identification</th>
                            <th class="px-10 py-8">Protocol Role</th>
                            <th class="px-10 py-8">Account State</th>
                            <th class="px-10 py-8">Deployment Date</th>
                            <th class="px-10 py-8 text-right">Moderation Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($users as $user)
                            <tr class="hover:bg-slate-50/40 transition-all group">
                                <td class="px-10 py-10">
                                    @php
                                        $detailRoute = $user->role->name == 'farmer' 
                                            ? route('admin.suppliers.show', $user->id) 
                                            : route('admin.customers.show', $user->id);
                                    @endphp
                                    <a href="{{ $detailRoute }}" class="flex items-center gap-5 group/profile">
                                        <div class="relative shrink-0">
                                            <div class="w-16 h-16 bg-slate-900 rounded-[22px] flex items-center justify-center text-white font-black text-xl group-hover/profile:scale-110 transition-transform duration-500 shadow-2xl shadow-slate-200">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-white rounded-full flex items-center justify-center shadow-lg border border-slate-50">
                                                <i class="fas {{ $user->role->name == 'farmer' ? 'fa-tractor text-green-600' : 'fa-user text-blue-600' }} text-[8px]"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="font-black text-slate-900 text-lg leading-tight group-hover/profile:text-green-600 transition-colors">{{ $user->name }}</p>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">{{ $user->email }}</p>
                                        </div>
                                    </a>
                                </td>
                                <td class="px-10 py-10">
                                    <span class="px-4 py-1.5 rounded-xl font-black text-[10px] uppercase tracking-widest {{ $user->role->name == 'farmer' ? 'bg-green-50 text-green-700' : 'bg-blue-50 text-blue-700' }}">
                                        {{ $user->role->name }}
                                    </span>
                                </td>
                                <td class="px-10 py-10">
                                    @if($user->status == 'active')
                                        <div class="flex items-center gap-3">
                                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                            <span class="text-[10px] font-black uppercase tracking-widest text-emerald-700">Authenticated</span>
                                        </div>
                                    @elseif($user->status == 'pending')
                                        <div class="flex items-center gap-3">
                                            <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                            <span class="text-[10px] font-black uppercase tracking-widest text-amber-700">Pending Review</span>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-3">
                                            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                            <span class="text-[10px] font-black uppercase tracking-widest text-rose-700">Access Denied</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-10 py-10">
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ $user->created_at->format('M d, Y') }}</p>
                                </td>
                                <td class="px-10 py-10 text-right">
                                    <div class="flex justify-end gap-3 items-center">
                                        @if($user->status != 'active')
                                            <form action="{{ route('admin.users.updateStatus', $user->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="active">
                                                <button class="bg-emerald-600 text-white px-5 py-2.5 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-emerald-700 shadow-xl shadow-emerald-100 transition-all active:scale-90">Approve</button>
                                            </form>
                                        @endif
                                        
                                        <button onclick='openAdminEditModal(@json($user))' class="w-12 h-12 flex items-center justify-center rounded-2xl bg-slate-50 text-slate-400 hover:bg-slate-900 hover:text-white transition-all shadow-sm group/btn" title="Modify Intel">
                                            <i class="fas fa-sliders text-xs group-hover/btn:rotate-90 transition-transform"></i>
                                        </button>

                                        @if($user->id !== Auth::id())
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('IDENTITY PROTOCOL: This action will permanently purge the user node and all associated trade data. Proceed?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-rose-50 text-rose-400 hover:bg-rose-500 hover:text-white transition-all shadow-sm" title="Purge Node">
                                                    <i class="fas fa-trash-can text-sm"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-16 flex justify-center">
            {{ $users->links() }}
        </div>
    </div>
</div>

<!-- Admin User Evolution Modal -->
<div id="adminEditModal" class="hidden fixed inset-0 z-[100] bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-6">
    <div class="bg-white rounded-[50px] w-full max-w-lg shadow-2xl animate-in zoom-in-95 duration-200 flex flex-col max-h-[90vh]">
        <div class="p-10 border-b border-slate-50 flex justify-between items-center bg-white rounded-t-[50px]">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Node Optimization</h2>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-1">Direct parameter adjustment</p>
            </div>
            <button onclick="document.getElementById('adminEditModal').classList.add('hidden')" class="w-12 h-12 rounded-2xl bg-slate-50 text-slate-400 hover:text-rose-500 transition-all flex items-center justify-center">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        
        <div class="flex-1 overflow-y-auto p-10 custom-scrollbar bg-white">
            <form id="adminEditForm" action="" method="POST" class="space-y-8">
                @csrf
                @method('PATCH')
                
                <div class="space-y-6">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block ml-1">Entity Name</label>
                        <input type="text" id="admin_edit_name" name="name" required class="w-full bg-slate-50 border-none rounded-2xl p-5 font-bold text-sm focus:ring-4 focus:ring-green-500/10 focus:border-green-500">
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block ml-1">Network Email</label>
                        <input type="email" id="admin_edit_email" name="email" required class="w-full bg-slate-50 border-none rounded-2xl p-5 font-bold text-sm focus:ring-4 focus:ring-green-500/10 focus:border-green-500">
                    </div>

                    <div id="admin_edit_farm_container">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block ml-1">Farm Node Designation</label>
                        <input type="text" id="admin_edit_farm_name" name="farm_name" class="w-full bg-slate-50 border-none rounded-2xl p-5 font-bold text-sm focus:ring-4 focus:ring-green-500/10 focus:border-green-500">
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block ml-1">Physical Node Coordinates (Address)</label>
                        <textarea id="admin_edit_address" name="address" rows="3" class="w-full bg-slate-50 border-none rounded-2xl p-5 font-bold text-sm focus:ring-4 focus:ring-green-500/10 focus:border-green-500"></textarea>
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block ml-1">Access Protocol State</label>
                        <select id="admin_edit_status" name="status" class="w-full bg-slate-50 border-none rounded-2xl p-5 font-bold text-sm focus:ring-4 focus:ring-green-500/10 focus:border-green-500">
                            <option value="active">Active</option>
                            <option value="pending">Pending</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <div class="p-10 bg-slate-50 border-t border-slate-100 rounded-b-[50px]">
            <button type="submit" form="adminEditForm" class="w-full bg-slate-900 text-white py-6 rounded-[28px] font-black uppercase tracking-widest hover:bg-black shadow-2xl shadow-slate-200 transition-all active:scale-95">
                Commit Logic Update
            </button>
        </div>
    </div>
</div>

<script>
    function openAdminEditModal(user) {
        const modal = document.getElementById('adminEditModal');
        const form = document.getElementById('adminEditForm');
        
        form.action = `/admin/users/${user.id}`;
        
        document.getElementById('admin_edit_name').value = user.name;
        document.getElementById('admin_edit_email').value = user.email;
        document.getElementById('admin_edit_address').value = user.address || '';
        document.getElementById('admin_edit_status').value = user.status;
        
        const farmContainer = document.getElementById('admin_edit_farm_container');
        if (user.role && user.role.name === 'farmer') {
            farmContainer.classList.remove('hidden');
            document.getElementById('admin_edit_farm_name').value = user.farm_name || '';
        } else {
            farmContainer.classList.add('hidden');
        }
        
        modal.classList.remove('hidden');
    }
</script>
@endsection
