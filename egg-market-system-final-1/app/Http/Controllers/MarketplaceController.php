<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    /**
     * Display the landing page with products.
     */
    public function home()
    {
        $featuredProducts = Product::with('user', 'category')->latest()->take(8)->get();

        // Dynamic stats for professional social proof
        $stats = [
            'farmers' => \App\Models\User::where('role_id', 2)->count(),
            'products' => Product::count(),
            'orders' => \App\Models\Order::count(),
            'revenue' => \App\Models\Order::where('status', 'delivered')->sum('total_amount'),
        ];

        return view('welcome', compact('featuredProducts', 'stats'));
    }

    /**
     * Display the egg marketplace.
     */
    public function index(Request $request)
    {
        $query = Product::with(['user', 'category']);

        // Correct Filtering Logic using Relationship
        if ($request->filled('category') && $request->category != 'All') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->category . '%');
            });
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $products = $query->latest()->paginate(12);

        return view('marketplace', [
            'products' => $products,
            'categories' => ['Chicken', 'Duck', 'Organic']
        ]);
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}
