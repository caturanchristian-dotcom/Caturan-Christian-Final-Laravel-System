<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $customerId = Auth::id();

        // 1. Total spent: total amount of all orders NOT cancelled
        $totalSpent = Order::where('user_id', $customerId)
            ->where('status', '!=', 'cancelled')
            ->sum('total_amount');

        // 2. Active Orders count (pending, processing, shipped)
        $activeOrdersCount = Order::where('user_id', $customerId)
            ->whereIn('status', ['pending', 'processing', 'shipped'])
            ->count();

        // 3. Total Deliveries completed (delivered)
        $completedOrdersCount = Order::where('user_id', $customerId)
            ->where('status', 'delivered')
            ->count();

        // 4. Recent Orders (latest 5)
        $recentOrders = Order::where('user_id', $customerId)
            ->latest()
            ->take(5)
            ->get();

        // 5. Spend Trend (Last 30 Days)
        $spendTrend = Order::where('user_id', $customerId)
            ->where('status', '!=', 'cancelled')
            ->where('created_at', '>=', now()->subDays(30))
            ->select(DB::raw('SUM(total_amount) as total'), DB::raw('DATE(created_at) as date'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // 6. Spend by Category
        $categoryDistribution = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('orders.user_id', $customerId)
            ->where('orders.status', '!=', 'cancelled')
            ->select('categories.name', DB::raw('SUM(order_items.price * order_items.quantity) as total_spend'))
            ->groupBy('categories.name')
            ->get();

        return view('customer.dashboard', compact(
            'totalSpent',
            'activeOrdersCount',
            'completedOrdersCount',
            'recentOrders',
            'spendTrend',
            'categoryDistribution'
        ));
    }
}
