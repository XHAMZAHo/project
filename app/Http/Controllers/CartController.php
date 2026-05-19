<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // ── Helpers ────────────────────────────────────────────────────────────
    private function getCart(): array
    {
        return session('cart', []);
    }

    private function saveCart(array $cart): void
    {
        session(['cart' => $cart]);
    }

    private function cartTotal(array $cart): float
    {
        return collect($cart)->sum(fn($i) => ($i['price'] ?? 0) * ($i['quantity'] ?? 1));
    }

    // ── Show Cart Page ──────────────────────────────────────────────────────
    public function index()
    {
        $cart  = $this->getCart();
        $total = $this->cartTotal($cart);
        return view('pages.cart', compact('cart', 'total'));
    }

    // ── Add Item ───────────────────────────────────────────────────────────
    public function add(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
        ]);

        $service = Service::findOrFail($request->service_id);
        $cart    = $this->getCart();
        $key     = 'service_' . $service->id;

        if (isset($cart[$key])) {
            // Already in cart – just notify
            if ($request->wantsJson()) {
                return response()->json(['status' => 'exists', 'count' => count($cart)]);
            }
            return back()->with('cart_info', __('cart.already_added'));
        }

        $cart[$key] = [
            'service_id'    => $service->id,
            'service_title' => app()->getLocale() === 'ar' ? $service->title_ar : $service->title_en,
            'icon'          => $service->icon,
            'price'         => (float)($service->price ?? 0),
            'price_type'    => $service->price_type,
            'price_label'   => $service->price_label,
            'quantity'      => 1,
        ];

        $this->saveCart($cart);

        if ($request->wantsJson()) {
            return response()->json(['status' => 'added', 'count' => count($cart)]);
        }
        return back()->with('cart_success', __('cart.added_success'));
    }

    // ── Remove Item ────────────────────────────────────────────────────────
    public function remove(Request $request, string $key)
    {
        $cart = $this->getCart();
        unset($cart[$key]);
        $this->saveCart($cart);

        if ($request->wantsJson()) {
            return response()->json(['status' => 'removed', 'count' => count($cart), 'total' => $this->cartTotal($cart)]);
        }
        return back()->with('cart_success', __('cart.removed'));
    }

    // ── Clear Cart ─────────────────────────────────────────────────────────
    public function clear()
    {
        $this->saveCart([]);
        return back()->with('cart_success', __('cart.cleared'));
    }

    // ── Show Checkout ──────────────────────────────────────────────────────
    public function checkout()
    {
        $cart = $this->getCart();
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('cart_error', __('cart.empty'));
        }
        $total = $this->cartTotal($cart);
        return view('pages.checkout', compact('cart', 'total'));
    }

    // ── Count (AJAX) ───────────────────────────────────────────────────────
    public function count()
    {
        return response()->json(['count' => count($this->getCart())]);
    }
}
