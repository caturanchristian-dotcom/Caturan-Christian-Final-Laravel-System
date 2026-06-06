@extends('layouts.main')

@section('title', 'Purchase History | Trade Registry')

@section('content')
<div class="animate-in fade-in duration-700 pb-20">
    <!-- Premium Header -->
    <div class="bg-white border-b border-slate-100 shadow-sm relative z-20">
        <div class="max-w-7xl mx-auto px-8 py-12">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-8">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></div>
                        <span class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Purchase Registry</span>
                    </div>
                    <h1 class="text-5xl font-black text-slate-900 tracking-tighter">Trade History</h1>
                    <p class="text-slate-400 font-semibold mt-1">Review your historical egg acquisitions and logistics logs.</p>
                </div>
                <a href="{{ route('marketplace') }}" class="px-8 py-4 bg-slate-900 text-white rounded-[22px] font-black text-xs uppercase tracking-widest hover:bg-black transition-all shadow-xl shadow-slate-200 active:scale-95 flex items-center gap-3">
                    <i class="fas fa-plus"></i> Initiate New Trade
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-8 py-12">
        <div class="bg-white rounded-[50px] border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                        <tr>
                            <th class="px-10 py-8">Protocol ID</th>
                            <th class="px-10 py-8">Acquisition Date</th>
                            <th class="px-10 py-8">Settlement</th>
                            <th class="px-10 py-8 text-center">Protocol State</th>
                            <th class="px-10 py-8 text-right">Operations</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($orders as $order)
                            <tr class="hover:bg-slate-50/40 transition-all group">
                                <td class="px-10 py-10 font-black text-slate-900 text-lg tracking-tighter">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-10 py-10">
                                    <p class="text-xs font-black text-slate-900">{{ $order->created_at->format('M d, Y') }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">{{ $order->created_at->format('h:i A') }}</p>
                                </td>
                                <td class="px-10 py-10 font-black text-slate-900 text-xl tracking-tight">₱{{ number_format($order->total_amount, 2) }}</td>
                                <td class="px-10 py-10 text-center">
                                    @php
                                        $statusClass = 'bg-slate-100 text-slate-600';
                                        if($order->status == 'delivered') $statusClass = 'bg-emerald-100 text-emerald-700';
                                        elseif($order->status == 'processing') $statusClass = 'bg-blue-100 text-blue-700';
                                        elseif($order->status == 'on the way') $statusClass = 'bg-purple-100 text-purple-700';
                                        elseif($order->status == 'cancelled') $statusClass = 'bg-rose-100 text-rose-700';
                                    @endphp
                                    <span class="px-4 py-1.5 rounded-full {{ $statusClass }} text-[10px] font-black uppercase tracking-widest shadow-sm">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="px-10 py-10 text-right">
                                    <div class="flex justify-end gap-3 items-center">
                                        @if($order->status == 'pending')
                                            <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('PROTOCOL: Confirm order cancellation?')">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="px-6 py-3 rounded-xl bg-rose-50 text-rose-500 font-black text-[10px] uppercase tracking-widest hover:bg-rose-500 hover:text-white transition-all">Cancel</button>
                                            </form>
                                        @endif
                                        
                                        @if($order->status == 'cancelled')
                                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('IDENTITY PROTOCOL: Purge this record?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="w-12 h-12 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-rose-500 hover:text-white transition-all shadow-sm">
                                                    <i class="fas fa-trash-alt text-xs"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <a href="{{ route('orders.show', $order->id) }}" class="w-12 h-12 flex items-center justify-center rounded-xl bg-slate-100 text-slate-600 hover:bg-green-600 hover:text-white transition-all shadow-sm">
                                            <i class="fas fa-chevron-right text-xs"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-40 text-center">
                                    <div class="w-24 h-24 bg-slate-50 text-slate-200 rounded-[40px] flex items-center justify-center mx-auto mb-8">
                                        <i class="fas fa-receipt text-4xl"></i>
                                    </div>
                                    <p class="text-slate-400 font-black uppercase tracking-widest text-sm">No transaction protocols detected.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-12">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
