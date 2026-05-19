<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    public function checkout(Request $request, Invoice $invoice)
    {
        // Require valid pay_token if not logged in
        if (!auth()->check() && $request->token !== $invoice->pay_token) {
            abort(403, 'Invalid payment link.');
        }

        if ($invoice->status === 'paid') {
            return redirect()->route('home')->with('info', 'This invoice is already paid.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $checkoutSession = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => strtolower($invoice->currency ?? 'usd'),
                    'product_data' => [
                        'name' => 'Invoice #' . $invoice->invoice_number,
                    ],
                    'unit_amount' => (int) ($invoice->total * 100),
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel'),
            'metadata' => [
                'invoice_id' => $invoice->id,
            ],
        ]);

        $invoice->update([
            'stripe_session_id' => $checkoutSession->id,
            'payment_gateway' => 'stripe'
        ]);

        return redirect()->away($checkoutSession->url);
    }

    public function success(Request $request)
    {
        // Verification handled by webhook, just show success page
        return view('client.invoices.payment-success');
    }

    public function cancel()
    {
        return view('client.invoices.payment-cancel');
    }
}
