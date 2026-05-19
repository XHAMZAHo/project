<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('items')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function($qb) use ($q) {
                $qb->where('order_number', 'like', "%{$q}%")
                   ->orWhere('customer_name', 'like', "%{$q}%")
                   ->orWhere('customer_email', 'like', "%{$q}%");
            });
        }

        $orders = $query->paginate(20)->withQueryString();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.service', 'user');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:pending,confirmed,in_progress,completed,cancelled']);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Order status updated.');
    }

    public function destroy(Order $order)
    {
        $order->items()->delete();
        $order->delete();
        return back()->with('success', 'Order deleted.');
    }
}
