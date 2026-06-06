<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()->latest()->paginate(10);
        return view('customer.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        $order->load('items.product.user'); // Load items and supplier info
        return view('customer.orders.show', compact('order'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart');

        if (!$cart) {
            return redirect()->back()->with('error', 'Cart is empty!');
        }

        return DB::transaction(function () use ($cart) {
            $total = array_reduce($cart, function($carry, $item) {
                return $carry + ($item['price'] * $item['quantity']);
            }, 0);

            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $total,
                'status' => 'pending'
            ]);

            foreach ($cart as $id => $details) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $details['quantity'],
                    'price' => $details['price']
                ]);

                // Deduct Stock
                $product = Product::find($id);
                $product->decrement('stock', $details['quantity']);
            }

            session()->forget('cart');

            return redirect()->route('orders.show', $order->id)->with('success', 'Order placed successfully!');
        });
    }

    public function cancel(Order $order)
    {
        if ($order->user_id !== Auth::id()) abort(403);

        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending orders can be cancelled.');
        }

        return DB::transaction(function () use ($order) {
            // Restock items
            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }

            $order->update(['status' => 'cancelled']);

            return redirect()->back()->with('success', 'Order #'.$order->id.' has been cancelled.');
        });
    }

    public function destroy(Order $order)
    {
        if ($order->user_id !== Auth::id()) abort(403);

        // Security check: Only cancelled orders can be deleted
        if ($order->status !== 'cancelled') {
            return redirect()->back()->with('error', 'Only cancelled orders can be removed from history.');
        }

        return DB::transaction(function () use ($order) {
            // Manually delete related records to prevent Integrity Constraint violations
            // if cascade delete is not yet active in your DB
            $order->items()->delete();

            // If you have a payments relationship
            if(method_exists($order, 'payments')) {
                $order->payments()->delete();
            }

            $order->delete();

            return redirect()->route('orders.index')->with('success', 'Cancelled order record has been removed.');
        });
    }
}
