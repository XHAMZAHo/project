<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Setting;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // ── Store Order + Redirect to WhatsApp ────────────────────────────────
    public function store(Request $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('cart_error', __('cart.empty'));
        }

        $request->validate([
            'customer_name'  => 'required|string|max:100',
            'customer_email' => 'nullable|email|max:150',
            'customer_phone' => 'nullable|string|max:30',
            'notes'          => 'nullable|string|max:1000',
        ]);

        $subtotal = collect($cart)->sum(fn($i) => ($i['price'] ?? 0) * ($i['quantity'] ?? 1));
        $total    = $subtotal;

        // Create the order
        $order = Order::create([
            'user_id'        => auth()->id(),
            'customer_name'  => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'notes'          => $request->notes,
            'subtotal'       => $subtotal,
            'total'          => $total,
            'status'         => 'pending',
            'payment_status' => 'unpaid',
            'whatsapp_sent'  => 'no',
        ]);

        // Create order items
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id'      => $order->id,
                'service_id'    => $item['service_id'] ?? null,
                'service_title' => $item['service_title'],
                'price'         => $item['price'] ?? 0,
                'quantity'      => $item['quantity'] ?? 1,
                'subtotal'      => ($item['price'] ?? 0) * ($item['quantity'] ?? 1),
            ]);
        }

        // Mark WhatsApp sent
        $order->update(['whatsapp_sent' => 'yes']);

        // Clear cart
        session()->forget('cart');

        // Build WhatsApp URL
        $phone   = Setting::get('whatsapp_number', '966500000000');
        $message = $order->whatsappMessage();
        $waUrl   = 'https://wa.me/' . preg_replace('/\D/', '', $phone) . '?text=' . urlencode($message);

        // Redirect to success page with WhatsApp URL
        session(['order_success' => [
            'order_number' => $order->order_number,
            'wa_url'       => $waUrl,
        ]]);

        return redirect()->route('order.success');
    }

    // ── Success Page ───────────────────────────────────────────────────────
    public function success()
    {
        $data = session('order_success');
        if (!$data) {
            return redirect()->route('home');
        }
        return view('pages.order-success', compact('data'));
    }
}
