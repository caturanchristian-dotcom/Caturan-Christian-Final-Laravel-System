<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FarmerController extends Controller
{
    public function dashboard()
    {
        $farmerId = Auth::id();
        
        // Stats
        $totalSales = Order::whereHas('items.product', function($q) use ($farmerId) {
            $q->where('user_id', $farmerId);
        })->where('status', 'delivered')->sum('total_amount');

        $activeOrders = Order::whereHas('items.product', function($q) use ($farmerId) {
            $q->where('user_id', $farmerId);
        })->whereIn('status', ['pending', 'processing'])->count();

        // Total available stock across all products
        $availableStock = Product::where('user_id', $farmerId)->sum('stock');

        // Fetch recent orders for the table
        $recentOrders = Order::whereHas('items.product', function($q) use ($farmerId) {
            $q->where('user_id', $farmerId);
        })->with('user')->latest()->take(5)->get();

        $lowStock = Product::where('user_id', $farmerId)->where('stock', '<', 15)->get();
        
        $notifications = Notification::where('user_id', $farmerId)->latest()->take(5)->get();

        // Chart 1: Daily Sales Trend (Last 7 Days)
        $salesTrend = Order::whereHas('items.product', function($q) use ($farmerId) {
                $q->where('user_id', $farmerId);
            })
            ->where('status', 'delivered')
            ->where('created_at', '>=', now()->subDays(7))
            ->select(DB::raw('SUM(total_amount) as total'), DB::raw('DATE(created_at) as date'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Chart 2: Stock by Category
        $stockByCategory = Product::where('user_id', $farmerId)
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('SUM(stock) as total_stock'))
            ->groupBy('categories.name')
            ->get();

        return view('farmer.dashboard', compact('totalSales', 'activeOrders', 'availableStock', 'recentOrders', 'lowStock', 'notifications', 'salesTrend', 'stockByCategory'));
    }

    public function manageProducts()
    {
        $products = Product::where('user_id', Auth::id())->latest()->get();
        return view('farmer.products.index', compact('products'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'unit' => 'required|in:Tray,Dozen',
            'description' => 'required|string',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image_url' => 'nullable|string'
        ]);

        $imagePath = null;

        // 1. Check for File Upload (Stores directly in the database as a Base64 encoded string)
        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $imagePath = 'data:' . $image->getMimeType() . ';base64,' . base64_encode(file_get_contents($image->getRealPath()));
        } 
        // 2. Check for External URL (Saves text URL to database)
        elseif ($request->filled('image_url')) {
            $imagePath = $request->image_url;
        } 
        else {
            return redirect()->back()->withErrors(['product_image' => 'Please provide an image file or a valid URL.']);
        }

        // 3. Save everything to Database
        Product::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'unit' => $request->unit,
            'image' => $imagePath, // Saved securely in database
        ]);

        return redirect()->back()->with('success', 'Product listed successfully!');
    }

    public function updateProduct(Request $request, Product $product)
    {
        if ($product->user_id !== Auth::id()) abort(403);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'unit' => 'required|in:Tray,Dozen',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image_url' => 'nullable|string'
        ]);

        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'unit' => $request->unit,
            'description' => $request->description,
            'category_id' => $request->category_id,
        ];

        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $data['image'] = 'data:' . $image->getMimeType() . ';base64,' . base64_encode(file_get_contents($image->getRealPath()));
        } elseif ($request->filled('image_url')) {
            $data['image'] = $request->image_url;
        }

        $product->update($data);

        return redirect()->back()->with('success', 'Product updated successfully!');
    }

    public function deleteProduct(Product $product)
    {
        if ($product->user_id !== Auth::id()) abort(403);
        $product->delete();
        return redirect()->back()->with('success', 'Product removed from market.');
    }

    public function manageOrders()
    {
        $farmerId = Auth::id();
        $orders = Order::whereHas('items.product', function($q) use ($farmerId) {
            $q->where('user_id', $farmerId);
        })->with(['items.product', 'user'])->latest()->paginate(10);

        return view('farmer.orders.index', compact('orders'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $validated = $request->validate(['status' => 'required|in:pending,processing,on the way,delivered']);
        $order->update(['status' => $validated['status']]);

        // Notify Customer
        Notification::create([
            'user_id' => $order->user_id,
            'message' => "Your order #{$order->id} is now {$validated['status']}",
            'type' => 'order'
        ]);

        return redirect()->back()->with('success', 'Order status updated to ' . $validated['status']);
    }

    public function reports()
    {
        $farmerId = Auth::id();
        
        $salesByCategory = Product::where('user_id', $farmerId)
            ->select('category_id', DB::raw('count(*) as total'))
            ->groupBy('category_id')
            ->get();

        return view('farmer.reports', compact('salesByCategory'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:100|unique:categories,name'
        ], [
            'category_name.unique' => 'This egg category already exists in the market.'
        ]);

        \App\Models\Category::create([
            'name' => $request->category_name
        ]);

        return redirect()->back()->with('success', 'New egg category added to the market!');
    }
}
