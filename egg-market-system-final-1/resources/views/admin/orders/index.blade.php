@extends('layouts.main')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <div class="mb-12">
        <h1 class="text-4xl font-black text-gray-900 tracking-tight">Platform Transactions</h1>
        <p class="text-gray-500 font-medium mt-2">Real-time monitoring of every egg trade on the network.</p>
    </div>

    <div class="bg-white rounded-[40px] border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                    <tr>
                        <th class="px-10 py-6">Order ID</th>
                        <th class="px-10 py-6">Customer</th>
                        <th class="px-10 py-6">Volume</th>
                        <th class="px-10 py-6">Revenue</th>
                        <th class="px-10 py-6">Fulfillment</th>
                        <th class="px-10 py-6 text-right">Reference</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($orders as $order)
                        <tr class="hover:bg-gray-50/50 transition-colors text-sm">
                            <td class="px-10 py-8 font-black text-gray-900">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-10 py-8 font-bold text-gray-600">{{ $order->user->name }}</td>
                            <td class="px-10 py-8">
                                <span class="bg-gray-100 px-3 py-1 rounded-lg font-black text-[10px] text-gray-500 uppercase tracking-widest">{{ $order->items->count() }} Items</span>
                            </td>
                            <td class="px-10 py-8 font-black text-gray-900 text-lg">₱{{ number_format($order->total_amount, 2) }}</td>
                            <td class="px-10 py-8">
                                <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest {{ $order->status == 'delivered' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="px-10 py-8 text-right">
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">{{ $order->created_at->format('M d, h:i A') }}</p>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-8">
        {{ $orders->links() }}
    </div>
</div>
@endsection
