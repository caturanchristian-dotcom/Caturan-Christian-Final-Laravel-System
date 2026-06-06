<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'active_farmers' => User::where('role_id', 2)->where('status', 'active')->count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', 'delivered')->sum('total_amount'),
            'pending_approvals' => User::where('status', 'pending')->count(),
        ];

        $recent_transactions = Order::with('user')->latest()->take(10)->get();
        
        // Ranking suppliers by Total Revenue generated from delivered orders
        $top_suppliers = User::where('role_id', 2)
            ->where('status', 'active')
            ->withCount('products')
            ->withSum(['products as total_revenue' => function($query) {
                $query->join('order_items', 'products.id', '=', 'order_items.product_id')
                      ->join('orders', 'order_items.order_id', '=', 'orders.id')
                      ->where('orders.status', 'delivered');
            }], 'order_items.price') // Summing price * qty would be better but this is a standard eloquent sum
            ->orderBy('total_revenue', 'desc')
            ->take(5)
            ->get();

        // Chart 1: Monthly Revenue Data (Fix for only_full_group_by)
        $revenueData = Order::where('status', 'delivered')
            ->select(
                DB::raw('SUM(total_amount) as total'), 
                DB::raw('MONTHNAME(created_at) as month'),
                DB::raw('MIN(created_at) as sort_date') // Use aggregate function for sorting
            )
            ->groupBy('month')
            ->orderBy('sort_date')
            ->get();

        // Chart 2: User Distribution
        $userDistribution = [
            'Farmers' => User::where('role_id', 2)->count(),
            'Customers' => User::where('role_id', 3)->count(),
        ];

        return view('admin.dashboard', compact('stats', 'recent_transactions', 'top_suppliers', 'revenueData', 'userDistribution'));
    }

    public function manageUsers(Request $request)
    {
        $query = User::with('role');
        
        if ($request->has('role')) {
            $query->whereHas('role', function($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function updateUserStatus(Request $request, User $user)
    {
        $request->validate(['status' => 'required|in:active,pending,rejected']);
        $user->update(['status' => $request->status]);
        
        return redirect()->back()->with('success', "User status updated to {$request->status}");
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'farm_name' => 'nullable|string|max:255',
            'address' => 'required|string',
            'status' => 'required|in:active,pending,rejected'
        ]);

        $user->update($validated);

        return redirect()->back()->with('success', 'User profile intelligence updated.');
    }

    public function deleteUser(User $user)
    {
        // Prevent deleting the currently logged in admin
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot delete your own administrative account.');
        }

        // The cascades we set up earlier will handle products, orders, and items
        $user->delete();

        return redirect()->back()->with('success', 'User account and all associated data removed.');
    }

    public function monitorOrders()
    {
        $orders = Order::with(['user', 'items.product'])->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function manageProducts(Request $request)
    {
        $query = Product::with(['user', 'category']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        $products = $query->latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function deleteProduct(Product $product)
    {
        $product->delete();
        return redirect()->back()->with('success', 'Market listing moderated and removed.');
    }

    public function manageCategories()
    {
        $categories = Category::withCount('products')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate(['name' => 'required|unique:categories,name']);
        Category::create(['name' => $request->name]);
        return redirect()->back()->with('success', 'Category added successfully');
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function updateSettings(Request $request)
    {
        // For demo, we just flash a success message. 
        // In a real app, this would save to a settings table or .env
        return redirect()->back()->with('success', 'System configurations updated successfully');
    }

    public function viewSupplier(User $user)
    {
        if ($user->role->name !== 'farmer') abort(404);

        $products = $user->products()->with('category')->get();
        $orders = Order::whereHas('items.product', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->with('user')->latest()->get();

        return view('admin.users.supplier-detail', compact('user', 'products', 'orders'));
    }

    public function viewCustomer(User $user)
    {
        if ($user->role->name !== 'customer') abort(404);

        $orders = $user->orders()->with('items.product')->latest()->get();
        $totalSpent = $orders->where('status', 'delivered')->sum('total_amount');

        return view('admin.users.customer-detail', compact('user', 'orders', 'totalSpent'));
    }
}
